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
    private static $instance = null;
    private static $config = [];

    private $permissions = [];

    public function __construct($staff_id, $data = [])
    {
        # całość jest łatwym do odczytu obiektem Entity
        parent::__construct($data);

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

        logger('[STAFF] Created', [$this->getProperty('name', 'Unnamed')]);
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

    /**
     * Sprawdza czy ciastko zostało wysłane i czy zawiera treść
     */
    public static function existsSessionCookie()
    {
        $name = getConfig()['session']['staff']['cookie']['name'];

        return isset($_COOKIE[$name]) and !empty($_COOKIE[$name]);
    }

    public static function createFromSession()
    {
        # zmień ustawienia
        static::configure();

        # jeżeli ciastko nie zostało nadesłane lub jest puste
        if (static::existsSessionCookie() === false) {
            static::abort('Cookie does not exists');
        }

        # rozpoczyna sesję
        static::start();

        # pobierz dane o pracowniku z tabelki sesji
        $data = ModelStaff::select()
            ->fields([
                'staff_id',
                'name',
                'email',
                'root',
                'lang',
                'expiry_datetime',
                'force_change_password',
            ])
            ->source('::session')
            ->equals('session_id', session_id())
            ->fetch();

        # jezeli sesja pracownika nie istnieje w bazie danych
        if (!$data) {
            static::abort("Staff session does not exists in database");
        }

        if ($data['expiry_datetime'] <= sqldate()) {
            static::abort('Session expired', '/auth/session-expired');
        }

        $staff_id = $data['staff_id'];

        # aktualizacja czasu wygaśnięcia sesji
        static::refreshSessionLifeTime($staff_id);

        # utworzenie obiektu pracownika
        return new static($staff_id, $data);
    }

    /**
     * Przekierowuje i ustawia wiadomość w logach
     */
    public static function abort($message, $location = '/auth/login')
    {
        logger("[STAFF] {$message}");
        static::destroySession();
        redirect($location);
    }

    /**
     * Tworzy sesję i przypisuje do niej $staff_id;
     */
    public static function createSession($staff_id)
    {
        # zmień ustawienia
        static::configure();

        # rozpoczyna sesję
        static::start();

        # aktualizacja czasu wygaśnięcia sesji
        static::refreshSessionLifeTime($staff_id);
    }

    /**
     * Niszczy sesję
     */
    public static function destroySession()
    {
        ModelStaffSession::delete()
            ->equals('session_id', session_id())
            ->execute();

        # jeżeli sesja jest ustanowiona
        if (session_status() === \PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        # usuń ciastko
        unset($_COOKIE[session_name()]);
        setcookie(session_name(), '', time() - 3600, '/');
    }

    /**
     * Konfiguruje mechanizm przechowywania sesji
     */
    protected static function configure()
    {
        # pobierz dane konfiguracyjne z configa
        static::$config = getConfig()['session']['staff'];

        # zmiana nazwy ciastka sesyjnego dla pracownika
        session_name(static::$config['cookie']['name']);

        # zmiana czasu żywotności ciastka
        session_set_cookie_params(static::$config['cookie']['lifetime']);

        if (static::$config['useCustomStorage']) {
            # włączenie niestandardowego sposobu przechowywania sesji
            session_set_save_handler(new DatabaseSessionHandler());
        }

        # ustaw, aby usuwać sesje starsze niż lifetime
        ini_set('session.gc_maxlifetime', static::$config['lifetime']);
    }

    /**
     * Rozpoczyna sesję
     */
    protected static function start()
    {
        # jeżeli sesja jest nieustanowiona
        if (session_status() === \PHP_SESSION_NONE) {

            # rozpocznij sesję, pobierz dane do $_SESSION
            session_start();

            logger('[SESSION]', [session_id()]);
        }
    }

    /**
     * Odświeża czas wygaśnięcia sesji
     */
    protected static function refreshSessionLifeTime($staff_id)
    {
        # aktualizacja czasu wygaśnięcia sesji w bazie danych
        ModelStaffSession::replace([
            'staff_id' => intval($staff_id),
            'session_id' => session_id(),
            'expiry_datetime' => sqldate(time() + static::$config['lifetime']),
        ]);
    }
}
