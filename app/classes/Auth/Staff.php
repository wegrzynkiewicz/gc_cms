<?php

namespace GC\Auth;

use GC\Url;
use GC\Logger;
use GC\Response;
use GC\Storage\AbstractEntity;
use GC\Model\Staff\Staff as ModelStaff;
use GC\Model\Staff\Permission as Permission;

class Staff extends AbstractEntity
{
    private $permissions = [];

    public function __construct()
    {
        $data = $staffQuery = ModelStaff::select()
            ->fields([
                'staff_id',
                'name',
                'email',
                'root',
                'lang',
                'force_change_password',
            ])
            ->source('::session')
            ->equals('session_id', session_id())
            ->fetch();

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
            ->equals('staff_id', $data['staff_id'])
            ->fetchByMap('name', 'name');

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($data['force_change_password']) {
            redirect('/auth/force-change-password');
        }

        logger('[STAFF]', [$data['name']]);
    }

    /**
     * Niszczy dane pracownika w sesji i przekierowuje na panel logowania
     */
    public function abort($message)
    {
        unset($_SESSION['staff']);
        StaffSession::destroy();
        logger("[LOGOUT] {$message}");
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

        return getConfig()['lang']['editorDefault'];
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
            logger('[DENY] Not authorized', $permissions);
            $perm = count($permissions) > 0 ? array_shift($permissions) : 'default';
            redirect("/admin/account/deny/{$perm}");
        }
    }
}
