<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class StaffPermission extends AbstractModel
{
    public static $table = '::staff_permissions';

    use ColumnTrait;

    public static function mapPermissionNameByGroupId($group_id)
    {
        $sql = self::sql("SELECT name FROM ::table WHERE group_id = ?");
        $permissions = Database::fetchMapBy($sql, [$group_id], 'name', 'name');

        return $permissions;
    }

    public static function mapPermissionNameByStaffId($staff_id)
    {
        $sql = self::sql("SELECT name FROM ::staff_membership JOIN ::table USING(group_id) WHERE staff_id = ?");
        $permissions = Database::fetchMapBy($sql, [$staff_id], 'name', 'name');

        return $permissions;
    }
}
