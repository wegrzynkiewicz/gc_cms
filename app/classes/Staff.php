<?php

namespace GC;

use GC\Storage\AbstractEntity;
use GC\Model\Staff\Staff as ModelStaff;
use GC\Model\Staff\Permission as Permission;

class Staff extends AbstractEntity
{
    private static $instance = null;
    private $permissions = [];

    public function __construct()
    {
        # pobierz wartość zmienną sesyjną
        $staff_id = getValueByKeys($_SESSION, ['staff', 'staff_id']);
        if (!$staff_id) {
            static::abort('Session variable does not contain valid data');
        }

        # pobierz dane o pracowniku z tabelki sesji
        $entity = ModelStaff::select()
            ->equals('staff_id', $staff_id)
            ->fetch();

        # jezeli sesja pracownika nie istnieje w bazie danych
        if (!$entity) {
            static::abort('Staff does not exists in database');
        }

        # całość jest łatwym do odczytu obiektem Entity
        parent::__construct($entity);

        # jeżeli czas wygaśnięcia sesji istnieje i minął czas trwania sesji
        $expires = getValueByKeys($_SESSION, ['staff', 'expires']);
        if ($expires and $expires <= time()) {
            static::abort('Session expired', '/auth/session-timeout');
        }

        # aktualizacja czasu wygaśnięcia sesji
        $_SESSION['staff']['expires'] = time() + $GLOBALS['config']['session']['staff']['lifetime'];

        # pobiera uprawnienia pracownika
        $this->permissions = Permission::select()
            ->fields('DISTINCT name')
            ->source('::staff_membership JOIN ::staff_permissions USING(group_id)')
            ->equals('staff_id', $staff_id)
            ->fetchByMap('name', 'name');

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($this->getProperty('force_change_password', false)) {
            redirect('/auth/force-change-password');
        }

        $GLOBALS['logger']->info('[STAFF] Authenticated', [$this->getProperty('name', 'Unnamed')]);
    }

    /**
     * Zwraca język edycji danych
     */
    public function getEditorLang()
    {
        # jeżeli w sesji nie ma języka edytora wtedy ustaw go z configa
        if (isset($_SESSION['langEditor'])) {
            return $_SESSION['langEditor'];
        }

        return $GLOBALS['config']['lang']['editorDefault'];
    }

    /**
     * Sprawdza czy pracownik ma uprawnienia do wykonania zadanych akcji
     */
    public function hasPermissions(array $requiredPermissions = [])
    {
        if (empty($requiredPermissions)) {
            return true;
        }

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
            $GLOBALS['logger']->info('[DENY] Not authorized', $permissions);
            $perm = count($permissions) > 0 ? array_shift($permissions) : 'default';
            redirect("/admin/account/deny/{$perm}");
        }
    }

    /**
     * Tworzy i pobiera tą samą instancję pracownika dla aplikacji
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Przekierowuje i ustawia wiadomość w logach
     */
    public static function abort($message, $location = '/auth/login')
    {
        $GLOBALS['logger']->info("[STAFF] {$message}");
        unset($_SESSION['staff']);
        redirect($location);
    }
}
