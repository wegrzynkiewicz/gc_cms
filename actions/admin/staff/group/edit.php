<?php

$group = GC\Model\StaffGroup::selectByPrimaryId($group_id);
$headTitle = trans('Edytowanie grupy pracowników "%s"', [$group['name']]);
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    GC\Model\StaffGroup::update($group_id, [
        'name' => $_POST['name'],
    ], $permissions);

    GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $group;
$permissions = GC\Model\StaffPermission::mapPermissionNameByGroupId($group_id);

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
