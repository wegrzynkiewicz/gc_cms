<?php

$headTitle = trans("Dodawanie nowej grupy pracowników");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    $group_id = GC\Model\StaffGroup::insert([
        'name' => $_POST['name'],
    ], $permissions);

    redirect('/admin/staff/group/list');
}

$permissions = [];

require_once ACTIONS_PATH.'/admin/staff/group/form.html.php';
