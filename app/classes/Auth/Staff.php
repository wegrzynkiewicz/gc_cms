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

    public function __construct($staff_id = 0)
    {
        $staffQuery = ModelStaff::select()
            ->fields([
                'staff_id',
                'name',
                'email',
                'root',
                'lang',
                'force_change_password',
            ]);

        if ($staff_id === 0) {
            $data = $staffQuery
                ->source('::session')
                ->equals('session_id', session_id())
                ->fetch();
        } else {
            $staffQuery
                ->source('::table')
                ->equals('staff_id', $staff_id);
        }

        # pobieranie pracownika z bazy danych
        $data = $staffQuery->fetch();

        # jezeli taki pracownik nie istnieje
        if (!$data) {
            static::abort("Staff session does not exists");
        }

        # całość jest łatwym do odczytu obiektem Entity
        parent::__construct($data);

        # pobiera uprawnienia pracownika
        $this->permissions = Permission::select()
            ->fields('DISTINCT name')
            ->source('::staff_membership JOIN ::staff_permissions USING(group_id)')
            ->equals('staff_id', $staff_id)
            ->fetchByMap('name', 'name');

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($data['force_change_password']) {
            redirect('/auth/force-change-password');
        }

        Data::get('logger')->staff($data['name']);
    }

    /**
     * Niszczy dane pracownika w sesji i przekierowuje na panel logowania
     */
    public function abort($message)
    {
        unset($_SESSION['staff']);
        StaffSession::destroy();
        Data::get('logger')->logout($message);
        redirect('/auth/login');
    }

    /**
     * Niszczy dane pracownika w sesji i przekierowuje na panel logowania
     */
    public static function abort($message)
    {
        unset($_SESSION['staff']);
        StaffSession::destroy();
        Data::get('logger')->logout($message);
        redirect('/auth/login');
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
}
