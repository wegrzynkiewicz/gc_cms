<?php

class StaffGroup extends Model
{
    public static $table   = '::staff_groups';
    public static $primary = 'group_id';

    use ColumnTrait;
    use PrimaryTrait;

    public static function selectAllAsOptionsByStaffId($staff_id)
    {
        $sql = self::sql("SELECT * FROM ::staff_membership LEFT JOIN ::table USING(::primary) WHERE staff_id = ?");
        $groups = Database::fetchAsOptionsWithPrimaryId($sql, [intval($staff_id)], static::$primary, 'name');

        return $groups;
    }

    protected static function update($group_id, $data, array $permissions)
    {
        # zaktualizuj grupę
        parent::updateByPrimaryId($group_id, [
            'name' => $data['name'],
        ]);

        static::updatePermissions($group_id, $permissions);
    }

    protected static function insert($data, array $permissions)
    {
        # wstaw grupę
        $group_id = parent::insert([
            'name' => $data['name'],
        ]);

        static::updatePermissions($group_id, $permissions);
    }

    private static function updatePermissions($group_id, array $permissions)
    {
        # usuń wszystkie uprawnienia tej grupy
        StaffPermission::deleteAllBy('group_id', $group_id);

        # wstaw na nowo uprawnienia grupy
        foreach ($permissions as $permission) {
            StaffPermission::insert([
                'group_id' => $group_id,
                'name' => $permission,
            ]);
        }
    }
}
