<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;

class Staff extends AbstractModel
{
    public static $table   = '::staff';
    public static $primary = 'staff_id';
    public static $session = '::staff JOIN ::staff_sessions USING(staff_id)';

    /**
     * Aktualizuje grupy pracownikow dla pracownika o $staff_id
     */
    public static function updateGroups($staff_id, array $groups)
    {
        # usuń wszystkie grupy tego pracownika
        Membership::delete()
            ->equals('staff_id', $staff_id)
            ->execute();

        # wstaw na nowo grupy pracownika
        foreach ($groups as $group_id) {
            Membership::insert([
                'group_id' => $group_id,
                'staff_id' => $staff_id,
            ]);
        }
    }
}
