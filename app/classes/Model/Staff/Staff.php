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

    public $permissions = [];

    public function __construct(array $data, array $permissions)
    {
        parent::__construct($data);
        $this->permissions = $permissions;

        $config = getConfig();

        # jeżeli w sesji nie ma języka edytora wtedy ustaw go z configa
        if (!isset($_SESSION['lang']['editor'])) {
            $_SESSION['lang']['editor'] = $config['lang']['editorDefault'];
        }

        # ustawienie jezyka panelu admina
        $_SESSION['lang']['staff'] = $data['lang'];

        # aktualizujemy czas do automatycznego wylogowania
        $_SESSION['staff']['sessionTimeout'] = time() + $config['session']['staffTimeout'];
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

        $permissions = Permission::mapPermissionNameByStaffId($staff_id);

        # utworz obiekt reprezentujacy pracownika
        $staff = new Staff($data, $permissions);

        return $staff;
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

        # jeżeli czas trwania sesji minął
        if (time() > $_SESSION['staff']['sessionTimeout']) {
            unset($_SESSION['staff']);
            Logger::logout("Session timeout");
            Response::redirect('/auth/session-timeout');
        }

        # spróbuj pobrać pracownika z bazy, jezeli go nie znajdzie wtedy przekieruj na logowanie
        try{
            # pobierz pracownika z bazy danych
            $staff = static::createByStaffId($_SESSION['staff']['entity']['staff_id']);
            $_SESSION['staff']['entity'] = $staff->getData();
        } catch (RuntimeException $exception) {
            unset($_SESSION['staff']);
            Logger::logout("Not found user");
            Response::redirect('/auth/login');
        }

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($staff['force_change_password']) {
            Response::redirect('/auth/force-change-password');
        }

        Logger::session(sprintf("%s <%s>", $staff['name'], $staff['email']));

        return $staff;
    }

    public static function selectAllCorrectWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE root = 0");

        return Database::fetchAllWithKey($sql, [], static::$primary);
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
