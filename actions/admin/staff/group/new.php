<?php

$headTitle = trans("Dodawanie nowej grupy pracowników");

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    $group_id = GCC\Model\StaffGroup::insert([
        'name' => $_POST['name'],
    ], $permissions);

    redirect('/admin/staff/group/list');
}

$permissions = [];

require_once ACTIONS_PATH.'/admin/staff/group/form.html.php';
