<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/staff/_import.php';
require ROUTES_PATH.'/admin/staff/group/_import.php';

$permissions = post('permissions', []);

# wstaw grupę
$group_id = GC\Model\Staff\Group::insert([
    'name' => post('name'),
]);

# wstaw uprawnienia grupy
foreach ($permissions as $permission) {
    GC\Model\Staff\Permission::insert([
        'group_id' => $group_id,
        'name' => $permission,
    ]);
}

flashBox(trans('Nowa grupa pracowników "%s" została utworzona.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
