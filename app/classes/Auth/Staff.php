<?php

namespace GC\Auth;

use GC\Data;
use GC\Url;
use GC\Logger;
use GC\Response;
use GC\Storage\AbstractEntity;
use GC\Model\Staff\Staff as ModelStaff;
use GC\Model\Staff\Permission as Permission;

class Staff extends AbstractEntity
{
    private $permissions = [];

    public function __construct($staff_id)
    {
        # pobieranie pracownika z bazy danych
        $data = ModelStaff::select()
            ->fields([
                'staff_id',
                'name',
                'email',
                'root',
                'lang',
                'force_change_password',
            ])
            ->equals('staff_id', $staff_id)
            ->fetch();

        # jezeli taki pracownik nie istnieje
        if (!$data) {
            static::abort("Staff entity id {$staff_id} does not exists");
        }

        # całość jest łatwym do odczytu obiektem Entity
        parent::__construct($data);

        # pobiera uprawnienia pracownika
        $this->permissions = Permission::select()
            ->fields('DISTINCT name')
            ->source('::staff_membership JOIN ::staff_permissions USING(group_id)')
            ->equals('staff_id', $staff_id)
            ->fetchByMap('name', 'name');

        # jeżeli czas trwania sesji minął
        if (time() > $_SESSION['staff']['sessionTimeout']) {
            static::abort('Session timeout');
        }

        static::refreshSessionTimeout();

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($data['force_change_password']) {
            redirect('/auth/force-change-password');
        }

        Data::get('logger')->staff($data['name']);
    }

    /**
     * Niszczy dane pracownika w sesji i przekierowuje na panel logowania
     */
    public static function abort($message)
    {
        unset($_SESSION['staff']);
        Data::get('logger')->logout($message);
        redirect('/auth/login');
    }

    /**
     * Pobiera dane sesyjne i tworzy obiekt pracownika na podstawie sesji
     */
    public static function createFromSession()
    {
        # jeżeli sesja nie istnieje wtedy przekieruj na logowanie
        if (!isset($_SESSION['staff'])) {
            static::abort('Session does not exists');
        }

        # jeżeli encja nie istnieje wtedy przekieruj na logowanie
        if (!isset($_SESSION['staff']['staff_id'])) {
            static::abort('Staff id does not exists');
        }

        # utworz obiekt reprezentujacy pracownika
        return new static($_SESSION['staff']['staff_id']);
    }

    /**
     * Zwraca język edycji danych
     */
    public static function getEditorLang()
    {
        # jeżeli w sesji nie ma języka edytora wtedy ustaw go z configa
        if (isset($_SESSION['staff']['langEditor'])) {
            return $_SESSION['staff']['langEditor'];
        }

        return Data::get('config')['lang']['editorDefault'];
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
     * Przekierowuje jezeli uzytkownik nie posiada uprawnień
     */
    public function redirectIfUnauthorized(array $permissions = [])
    {
        if (!$this->hasPermissions($permissions)) {
            Data::get('logger')->deny("Not authorized", $permissions);
            $perm = count($permissions) > 0 ? array_shift($permissions) : 'default';
            redirect("/admin/account/deny/{$perm}");
        }
    }

    /**
     * Tworzy sesję dla zadanego $staff_id
     */
    public static function registerSession($staff_id)
    {
        $_SESSION['staff']['staff_id'] = $staff_id;
        static::refreshSessionTimeout();
    }

    /**
     * Aktualizuje czas do automatycznego wylogowania
     */
    public static function refreshSessionTimeout()
    {
        $_SESSION['staff']['sessionTimeout'] = time() + Data::get('config')['session']['staff']['timeout'];
    }

    /**
     * Aktualizuje czas do automatycznego wylogowania
     */
    public static function startSession()
    {
        # zmiana nazwy ciastka sesyjnego dla pracownika
        ini_set('session.name', Data::get('config')['session']['staff']['cookieName']);

        # rozpoczęcie sesji
        session_start();

        $tokenCSRF = new CSRFToken();

        # sprawdzenie poprawności tokenu csrf, tylko gdy metoda post
        if (Data::get('request')->isMethod('POST')) {
            $tokenCSRF->assert();
        }

        # utworzenie nowego tokenu, jeżeli nie został zarejestrowany
        if (!$tokenCSRF->isRegistered()) {
            $tokenCSRF->register();
        }
    }
}
