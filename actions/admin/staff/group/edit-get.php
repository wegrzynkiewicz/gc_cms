<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';
require ACTIONS_PATH.'/admin/staff/group/_import.php';

$group_id = intval(array_shift($_PARAMETERS));

# pobierz grupę po kluczu głównym
$group = GC\Model\Staff\Group::fetchByPrimaryId($group_id);

$headTitle = $trans('Edytowanie grupy pracowników "%s"', [$group['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $group;

# pobierz uprawnienia dla grupy
$permissions = GC\Model\Staff\Permission::select()
    ->fields(['name'])
    ->equals('group_id', $group_id)
    ->fetchByMap('name', 'name');

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
