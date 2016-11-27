<?php

class StaffPermissionModel extends AbstractModel
{
    public static $table = '::staff_permissions';

    public static function selectPermissionsAsOptionsByGroupId($group_id)
    {
        $sql = self::sql("SELECT name FROM ::table WHERE group_id = ?");
        $permissions = Database::fetchAll($sql, [$group_id]);

        foreach ($permissions as &$permission) {
            $permission = $permission['name'];
        }
        unset($permission);

        return $permissions;
    }

    public static function selectPermissionsAsOptionsByStaffId($staff_id)
    {
        $sql = self::sql("SELECT name FROM ::staff_membership JOIN ::table USING(group_id) WHERE staff_id = ?");
        $permissions = Database::fetchAll($sql, [$staff_id]);

        foreach ($permissions as &$permission) {
            $permission = $permission['name'];
        }
        unset($permission);

        return $permissions;
    }
}
