<?php

$headTitle = trans("Edytowanie grupy pracowników");

$staff->redirectIfUnauthorized();

$group_id = intval(array_shift($_SEGMENTS));
$group = StaffGroup::selectByPrimaryId($group_id);

if (!$group) {
    redirect('/admin/staff/group/list');
}

if (wasSentPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    StaffGroup::update($group_id, [
        'name' => $_POST['name'],
    ], $permissions);

    redirect('/admin/staff/group/list');
}

$headTitle .= makeLink("/admin/staff/group/list", $group['name']);

$_POST = $group;
$permissions = StaffPermission::selectPermissionsAsOptionsByGroupId($group_id);

require_once ACTIONS_PATH.'/admin/staff/group/form.html.php';
