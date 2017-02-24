<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/staff/_import.php';
require ROUTES_PATH.'/admin/staff/group/_import.php';

$group_id = intval(array_shift($_PARAMETERS));

# pobierz grupę po kluczu głównym
$group = GC\Model\Staff\Group::fetchByPrimaryId($group_id);

$headTitle = trans('Edytowanie grupy pracowników: %s', [$group['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $group;

# pobierz uprawnienia dla grupy
$permissions = GC\Model\Staff\Permission::select()
    ->fields(['name'])
    ->equals('group_id', $group_id)
    ->fetchByMap('name', 'name');

require ROUTES_PATH.'/admin/staff/group/_form.html.php';
