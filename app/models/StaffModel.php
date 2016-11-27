<?php

class StaffModel extends AbstractModel
{
    public static $table      = '::staff';
    public static $primary    = 'staff_id';
    public static $groupTable = '::staff_membership';
    public static $groupName  = 'group_id';

    public static function selectAll()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE root = 0");

        return Database::fetchAllWithPrimaryId($sql, [], static::$primary);
    }

    protected static function update($staff_id, $data, array $groups)
    {
        # zaktualizuj pracownika
        parent::update($staff_id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
        ]);

        static::updateGroups($staff_id, $groups);
    }

    protected static function insert($data, array $groups)
    {
        # wstaw pracownika
        $staff_id = parent::insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
        ]);

        static::updateGroups($staff_id, $groups);
    }

    private static function updateGroups($staff_id, array $groups)
    {
        # usuń wszystkie grupy tego pracownika
        $sql = self::sql("DELETE FROM ::groupTable WHERE ::primary = ?");
        Database::execute($sql, [$staff_id]);

        # wstaw na nowo grupy pracownika
        foreach ($groups as $group_id) {
            Database::insertDataToTable(static::$groupTable, [
                static::$groupName => $group_id,
                static::$primary => $staff_id,
            ]);
        }
    }
}
