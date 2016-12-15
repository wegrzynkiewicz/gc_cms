<?php

$group_id = intval(array_shift($_SEGMENTS));
$group = GC\Model\StaffGroup::selectByPrimaryId($group_id);

$headTitle = trans('Edytowanie grupy pracowników "%s"', [$group['name']]);
$breadcrumbs->push($request, $headTitle);

if (wasSentPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    GC\Model\StaffGroup::update($group_id, [
        'name' => $_POST['name'],
    ], $permissions);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $group;
$permissions = GC\Model\StaffPermission::selectPermissionsAsOptionsByGroupId($group_id);

require_once ACTIONS_PATH.'/admin/staff/group/form.html.php';
