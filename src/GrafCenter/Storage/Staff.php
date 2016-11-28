<?php

class Staff extends Entity
{
    public $permissions = [];

    public function __construct(array $data, array $permissions)
    {
        parent::__construct($data);
        $this->permissions = $permissions;

        # jeżeli w sesji nie ma języka edytora wtedy ustaw go z configa
        if (!isset($_SESSION['staff']['editorLang'])) {
            $_SESSION['staff']['editorLang'] = getConfig()['lang']['editorDefault'];
        }
    }

    /**
     * Przekierowuje jezeli uzytkownik nie posiada uprawnień
     */
    public function redirectIfUnauthorized(array $permissions = [])
    {
        if (!$this->hasPermissions($permissions)) {
            logger("[DENY] Not authorized", $permissions);
            $perm = count($permissions) > 0 ? array_shift($permissions) : 'default';
            redirect("/admin/deny/$perm");
        }
    }

    /**
     * Sprawdza czy pracownik ma uprawnienia do wykonania zadanych akcji
     */
    public function hasPermissions(array $requiredPermissions = [])
    {
        if ($this['root'] == 1) {
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
        global $config;

        if (empty($staff['avatar'])) {
            return assetsUrl($config['avatar']['noAvatarUrl']);
        }

        return thumb($staff['avatar'], $size, $size);
    }

    /**
     * Pobiera dane i tworzy obiekt pracownika o zadanym id
     */
    public static function createByStaffId($staff_id)
    {
        # pobierz pracownika z bazy danych
        $data = StaffModel::selectByPrimaryId($staff_id);

        # jezeli taki uzytkownik zostal usuniety, albo nie istnieje wtedy wyjątek
        if (!$data) {
            throw new RuntimeException(sprintf(
                "Staff by id %s does not exists", $staff_id
            ));
        }

        $permissions = StaffPermissionModel::selectPermissionsAsOptionsByStaffId($staff_id);

        # utworz obiekt reprezentujacy pracownika
        $staff = new Staff($data, $permissions);

        return $staff;
    }

    /**
     * Pobiera dane i tworzy obiekt pracownika na podstawie sesji
     */
    public static function createFromSession()
    {
        $config = getConfig();

        # jeżeli sesja nie istnieje wtedy przekieruj na logowanie
        if (!isset($_SESSION['staff'])) {
            unset($_SESSION['staff']);
            logger("[LOGOUT] Session does not exists");
            redirect('/admin/login');
        }

        # spróbuj pobrać pracownika z bazy, jezeli go nie znajdzie wtedy przekieruj na logowanie
        try{
            # pobierz pracownika z bazy danych
            $staff = static::createByStaffId($_SESSION['staff']['staff_id']);
        } catch (RuntimeException $exception) {
            unset($_SESSION['staff']);
            logger("[LOGOUT] Not found user");
            redirect('/admin/login');
        }

        logger(sprintf("[SESSION] %s <%s>",
            $staff['name'],
            $staff['email']
        ));

        return $staff;
    }
}
