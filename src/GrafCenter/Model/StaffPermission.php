<?php

class StaffPermission extends Model
{
    public static $table = '::staff_permissions';

    use ColumnTrait;

    public static function selectPermissionsAsOptionsByGroupId($group_id)
    {
        $sql = self::sql("SELECT name FROM ::table WHERE group_id = ?");
        $permissions = Database::fetchAsOptionsWithPrimaryId($sql, [$group_id], 'name', 'name');

        return $permissions;
    }

    public static function selectPermissionsAsOptionsByStaffId($staff_id)
    {
        $sql = self::sql("SELECT name FROM ::staff_membership JOIN ::table USING(group_id) WHERE staff_id = ?");
        $permissions = Database::fetchAsOptionsWithPrimaryId($sql, [$staff_id], 'name', 'name');

        return $permissions;
    }
}
