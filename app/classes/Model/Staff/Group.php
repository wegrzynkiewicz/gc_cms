<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Group extends AbstractModel
{
    public static $table   = '::staff_groups';
    public static $primary = 'group_id';

    use ColumnTrait;
    use PrimaryTrait;

    public static function update($group_id, $data, array $permissions)
    {
        # zaktualizuj grupę
        parent::updateByPrimaryId($group_id, [
            'name' => $data['name'],
        ]);

        static::updatePermissions($group_id, $permissions);
    }

    protected static function insertWithPermissions($data, array $permissions)
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
        Permission::deleteAllBy('group_id', $group_id);

        # wstaw na nowo uprawnienia grupy
        foreach ($permissions as $permission) {
            Permission::insert([
                'group_id' => $group_id,
                'name' => $permission,
            ]);
        }
    }
}
