<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/staff/_import.php';
require ROUTES_PATH.'/admin/staff/group/_import.php';

$group_id = intval(array_shift($_PARAMETERS));
$permissions = post('permissions', []);

# zaktualizuj grupę pracowników
GC\Model\Staff\Group::updateByPrimaryId($group_id, [
    'name' => post('name'),
]);

# usuń wszystkie uprawnienia tej grupy
GC\Model\Staff\Permission::delete()
    ->equals('group_id', $group_id)
    ->execute();

# wstaw uprawnienia grupy
foreach ($permissions as $permission) {
    GC\Model\Staff\Permission::insert([
        'group_id' => $group_id,
        'name' => $permission,
    ]);
}

flashBox(trans('Grupa pracowników "%s" została zaktualizowana.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
