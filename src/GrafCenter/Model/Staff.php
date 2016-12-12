<?php

class Staff extends Model
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

        # jeżeli w sesji nie ma języka edytora wtedy ustaw go z configa
        if (!isset($_SESSION['lang']['editor'])) {
            $_SESSION['lang']['editor'] = getConfig()['lang']['editorDefault'];
        }

        # ustawienie jezyka panelu admina
        $_SESSION['lang']['staff'] = $data['lang'];
    }

    /**
     * Przekierowuje jezeli uzytkownik nie posiada uprawnień
     */
    public function redirectIfUnauthorized(array $permissions = [])
    {
        if (!$this->hasPermissions($permissions)) {
            Logger::deny("Not authorized", $permissions);
            $perm = count($permissions) > 0 ? array_shift($permissions) : 'default';
            redirect("/admin/account/deny/$perm");
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
            return assetsUrl(getConfig()['avatar']['noAvatarUrl']);
        }

        return thumb($staff['avatar'], $size, $size);
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

        $permissions = StaffPermission::selectPermissionsAsOptionsByStaffId($staff_id);

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
        if (!isset($_SESSION['staff'])) {
            unset($_SESSION['staff']);
            Logger::logout("Session does not exists");
            redirect('/admin/login');
        }

        # spróbuj pobrać pracownika z bazy, jezeli go nie znajdzie wtedy przekieruj na logowanie
        try{
            # pobierz pracownika z bazy danych
            $staff = static::createByStaffId($_SESSION['staff']['staff_id']);
        } catch (RuntimeException $exception) {
            unset($_SESSION['staff']);
            Logger::logout("Not found user");
            redirect('/admin/login');
        }

        # jezeli istnieje flaga, ze trzeba zmienić hasło wtedy przekieruj
        if ($staff['force_change_password']) {
            redirect('/admin/account/force-change-password');
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

    protected static function insert(array $data, array $groups)
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
        StaffMembership::deleteAllBy('staff_id', $staff_id);

        # wstaw na nowo grupy pracownika
        foreach ($groups as $group_id) {
            StaffMembership::insert([
                'group_id' => $group_id,
                'staff_id' => $staff_id,
            ]);
        }
    }
}
