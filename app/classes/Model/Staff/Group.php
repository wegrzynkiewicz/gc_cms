<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;

class Group extends AbstractModel
{
    public static $table   = '::staff_groups';
    public static $primary = 'group_id';

    use PrimaryTrait;

    public static function updatePermissions($group_id, array $permissions)
    {
        # usuń wszystkie uprawnienia tej grupy
        Permission::delete()->equals('group_id', $group_id)->execute();

        # wstaw na nowo uprawnienia grupy
        foreach ($permissions as $permission) {
            Permission::insert([
                'group_id' => $group_id,
                'name' => $permission,
            ]);
        }
    }
}
