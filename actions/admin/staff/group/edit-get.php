<?php

$group_id = intval(array_shift($_PARAMETERS));
$group = GC\Model\Staff\Group::fetchByPrimaryId($group_id);
$headTitle = $trans('Edytowanie grupy pracowników "%s"', [$group['name']]);
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$_POST = $group;
$permissions = GC\Model\Staff\Permission::select()
    ->fields(['name'])
    ->equals('group_id', $group_id)
    ->fetchByMap('name', 'name');

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
