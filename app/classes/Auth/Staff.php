<?php

namespace GC\Auth;

use GC\Url;
use GC\Logger;
use GC\Response;
use GC\Storage\AbstractEntity;
use GC\Model\Staff\Staff as ModelStaff;
use GC\Model\Staff\Session as ModelStaffSession;
use GC\Model\Staff\Permission as Permission;

class Staff extends AbstractEntity
{
    private $permissions = [];

    public function __construct(array $data = [], array $permissions = [])
    {
        # całość jest łatwym do odczytu obiektem Entity
        parent::__construct($data);

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
     * Sprawdza czy ciastko zostało wysłane i czy zawiera treść
     */
    public static function existsSessionCookie()
    {
        $name = $GLOBALS['config']['session']['staff']['cookie']['name'];

        return isset($_COOKIE[$name]) and !empty($_COOKIE[$name]);
    }

    public static function createFromSession()
    {
        # jeżeli ciastko nie zostało nadesłane lub jest puste
        if (static::existsSessionCookie() === false) {
            static::abort('Cookie does not exists');
        }

        # rozpoczyna sesję
        static::start();

        $staff_id = getValueByKeys($_SESSION, ['staff', 'entity', 'staff_id'], null);

        if ($staff_id === null) {
            static::abort('Session variable does not contain valid data');
        }

        if ($_SESSION['staff']['expires'] <= time()) {
            static::abort('Session expired', '/auth/session-expired');
        }

        # aktualizacja czasu wygaśnięcia sesji
        static::refreshSessionLifeTime($staff_id);

        # utworzenie obiektu pracownika
        return new static(
            $_SESSION['staff']['entity'],
            $_SESSION['staff']['permissions']
        );
    }

    /**
     * Przekierowuje i ustawia wiadomość w logach
     */
    public static function abort($message, $location = '/auth/login')
    {
        $GLOBALS['logger']->info("[STAFF] {$message}");
        static::destroySession();
        redirect($location);
    }

    /**
     * Tworzy sesję i przypisuje do niej $staff_id;
     */
    public static function createSession($staff_id)
    {
        # rozpoczyna sesję
        static::start();

        # pobierz dane o pracowniku z tabelki sesji
        $entity = ModelStaff::select()
            ->equals('staff_id', $staff_id)
            ->fetch();

        # jezeli sesja pracownika nie istnieje w bazie danych
        if (!$entity) {
            static::abort("Staff does not exists in database");
        }

        $_SESSION['staff']['entity'] = $entity;

        # pobiera uprawnienia pracownika
        $permissions = Permission::select()
            ->fields('DISTINCT name')
            ->source('::staff_membership JOIN ::staff_permissions USING(group_id)')
            ->equals('staff_id', $staff_id)
            ->fetchByMap('name', 'name');

        $_SESSION['staff']['permissions'] = $permissions;

        # aktualizacja czasu wygaśnięcia sesji
        static::refreshSessionLifeTime($staff_id);
    }

    /**
     * Niszczy sesję
     */
    public static function destroySession()
    {
        # jeżeli sesja jest ustanowiona
        if (session_status() === \PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        # usuń ciastko
        unset($_COOKIE[session_name()]);
        setcookie(session_name(), '', time() - 3600, '/');
    }

    /**
     * Rozpoczyna sesję
     */
    protected static function start()
    {
        # pobierz dane konfiguracyjne z configa
        $config = $GLOBALS['config']['session']['staff'];

        # zmiana nazwy ciastka sesyjnego dla pracownika
        session_name($config['cookie']['name']);

        # zmiana czasu żywotności ciastka
        session_set_cookie_params($config['cookie']['lifetime']);

        # ustaw, aby usuwać sesje starsze niż lifetime
        ini_set('session.gc_maxlifetime', $config['lifetime']);

        # jeżeli sesja jest nieustanowiona
        if (session_status() === \PHP_SESSION_NONE) {

            # rozpocznij sesję, pobierz dane do $_SESSION
            session_start();

            $GLOBALS['logger']->info('[SESSION]', [session_id()]);
        }
    }

    /**
     * Odświeża czas wygaśnięcia sesji
     */
    protected static function refreshSessionLifeTime($staff_id)
    {
        # aktualizacja czasu wygaśnięcia sesji
        $_SESSION['staff']['expires'] = time() + $GLOBALS['config']['session']['staff']['lifetime'];
    }
}
