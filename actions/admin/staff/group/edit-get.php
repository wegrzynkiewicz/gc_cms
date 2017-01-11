<?php

$group = GC\Model\Staff\Group::selectByPrimaryId($group_id);
$headTitle = trans('Edytowanie grupy pracowników "%s"', [$group['name']]);
$breadcrumbs->push($request->path, $headTitle);

$_POST = $group;
$permissions = GC\Model\Staff\Permission::select()
    ->fields(['name'])
    ->equals('group_id', $group_id)
    ->fetchByMap('name', 'name');

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
