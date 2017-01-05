<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class Permission extends AbstractModel
{
    public static $table = '::staff_permissions';

    use ColumnTrait;

    public static function mapPermissionNameByGroupId($group_id)
    {
        $sql = self::sql("SELECT name FROM ::table WHERE group_id = ?");
        $permissions = Database::fetchByMap($sql, [$group_id], 'name', 'name');

        return $permissions;
    }

    public static function mapPermissionNameByStaffId($staff_id)
    {
        $sql = self::sql("SELECT name FROM ::staff_membership JOIN ::table USING(group_id) WHERE staff_id = ?");
        $permissions = Database::fetchByMap($sql, [$staff_id], 'name', 'name');

        return $permissions;
    }
}
