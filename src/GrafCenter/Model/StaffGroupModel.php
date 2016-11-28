<?php

class StaffGroupModel extends AbstractModel
{
    public static $table      = '::staff_groups';
    public static $primary    = 'group_id';

    public static function selectAllAsOptionsByStaffId($staff_id)
    {
        $sql = self::sql("SELECT * FROM ::staff_membership LEFT JOIN ::table USING(::primary) WHERE staff_id = ?");
        $groups = Database::fetchAllWithPrimaryId($sql, [$staff_id], static::$primary);

        foreach ($groups as &$group) {
            $group = $group['name'];
        }
        unset($group);

        return $groups;
    }

    protected static function update($group_id, $data, array $permissions)
    {
        # zaktualizuj grupę
        parent::update($group_id, [
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
        StaffPermissionModel::deleteBy('group_id', $group_id);

        # wstaw na nowo uprawnienia grupy
        foreach ($permissions as $permission) {
            StaffPermissionModel::insert([
                'group_id' => $group_id,
                'name' => $permission,
            ]);
        }
    }
}
