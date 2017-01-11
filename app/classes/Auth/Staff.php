<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;
use GC\Url;
use GC\Logger;
use GC\Response;
use RuntimeException;

class Staff extends AbstractModel
{
    public static $table   = '::staff';
    public static $primary = 'staff_id';

    use ColumnTrait;
    use PrimaryTrait;

    /**
     * Uruchamia proces przetwarzania sesji
     */
    public function start()
    {
    }

    public function __construct(array $data, array $permissions)
    {
        parent::__construct($data);
        $_SESSION['staff']['entity'] = $data;

        $this->permissions = $permissions;

        $config = getConfig();

        # jeżeli w sesji nie ma języka edytora wtedy ustaw go z configa
        if (!isset($_SESSION['lang']['editor'])) {
            $_SESSION['lang']['editor'] = $config['lang']['editorDefault'];
        }

        # ustawienie jezyka panelu admina
        $_SESSION['lang']['staff'] = $data['lang'];

        # jeżeli czas trwania sesji minął
        if (time() > $_SESSION['staff']['sessionTimeout']) {
            unset($_SESSION['staff']);
            Logger::logout("Session timeout");
            Response::redirect('/auth/session-timeout');
        }

        static::refreshSessionTimeout();

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($data['force_change_password']) {
            Response::redirect('/auth/force-change-password');
        }

        Logger::auth(sprintf("%s <%s>", $data['name'], $data['email']));
    }

    /**
     * Przekierowuje jezeli uzytkownik nie posiada uprawnień
     */
    public function redirectIfUnauthorized(array $permissions = [])
    {
        if (!$this->hasPermissions($permissions)) {
            Logger::deny("Not authorized", $permissions);
            $perm = count($permissions) > 0 ? array_shift($permissions) : 'default';
            Response::redirect("/admin/account/deny/{$perm}");
        }
    }

    /**
     * Sprawdza czy pracownik ma uprawnienia do wykonania zadanych akcji
     */
    public function hasPermissions(array $requiredPermissions = [])
    {
        if (intval($this->getProperty('root', 0)) === 1) {
            return true;
        }

        foreach ($requiredPermissions as $requiredPermission) {
            if (!in_array($requiredPermission, $this->permissions)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Zwraca url avatara zadanego pracownika
     */
    public static function getAvatarUrl($staff, $size)
    {
        if (empty($staff['avatar'])) {
            return Url::assets(getConfig()['avatar']['noAvatarUrl']);
        }

        return Thumb::make($staff['avatar'], $size, $size);
    }

    /**
     * Pobiera dane i tworzy obiekt pracownika o zadanym id
     */
    public static function createByStaffId($staff_id)
    {
        # pobierz pracownika z bazy danych
        $data = static::selectByPrimaryId($staff_id);

        # jezeli taki uzytkownik zostal usuniety, albo nie istnieje wtedy wyjątek
        if (!$data) {
            throw new RuntimeException(sprintf(
                "Staff by id %s does not exists", $staff_id
            ));
        }

        $permissions = Permission::select()
            ->fields(['name'])
            ->from('::staff_membership JOIN ::staff_permissions USING(group_id)')
            ->equals('staff_id', $staff_id)
            ->fetchByMap('name', 'name');

        # utworz obiekt reprezentujacy pracownika
        $staff = new Staff($data, $permissions);

        return $staff;
    }

    public static function refreshSessionTimeout()
    {
        # aktualizujemy czas do automatycznego wylogowania
        $_SESSION['staff']['sessionTimeout'] = time() + getConfig()['session']['staffTimeout'];
    }

    /**
     * Pobiera dane i tworzy obiekt pracownika na podstawie sesji
     */
    public static function createFromSession()
    {
        # jeżeli sesja nie istnieje wtedy przekieruj na logowanie
        if (!isset($_SESSION['staff']) or !isset($_SESSION['staff']['entity'])) {
            unset($_SESSION['staff']);
            Logger::logout("Session does not exists");
            Response::redirect('/auth/login');
        }

        # spróbuj pobrać pracownika z bazy, jezeli go nie znajdzie wtedy przekieruj na logowanie
        try{
            # pobierz pracownika z bazy danych
            return static::createByStaffId($_SESSION['staff']['entity']['staff_id']);
        } catch (RuntimeException $exception) {
            unset($_SESSION['staff']);
            Logger::logout("Not found user");
            Response::redirect('/auth/login');
        }
    }

    protected static function update($staff_id, array $data, array $groups)
    {
        # zaktualizuj pracownika
        parent::updateByPrimaryId($staff_id, $data);
        static::updateGroups($staff_id, $groups);
    }

    protected static function insertWithGroups(array $data, array $groups)
    {
        # wstaw pracownika
        $staff_id = parent::insert($data);
        static::updateGroups($staff_id, $groups);
    }

    /**
     * Aktualizuje grupy pracownikow dla pracownika o $staff_id
     */
    private static function updateGroups($staff_id, array $groups)
    {
        # usuń wszystkie grupy tego pracownika
        Membership::deleteAllBy('staff_id', $staff_id);

        # wstaw na nowo grupy pracownika
        foreach ($groups as $group_id) {
            Membership::insert([
                'group_id' => $group_id,
                'staff_id' => $staff_id,
            ]);
        }
    }
}
