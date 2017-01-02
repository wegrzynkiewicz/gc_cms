<?php

$group = GC\Model\Staff\Group::selectByPrimaryId($group_id);
$headTitle = trans('Edytowanie grupy pracowników "%s"', [$group['name']]);
$breadcrumbs->push($request->path, $headTitle);

$_POST = $group;
$permissions = GC\Model\Staff\Permission::mapPermissionNameByGroupId($group_id);

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
