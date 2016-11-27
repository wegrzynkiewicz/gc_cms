<?php

$headTitle = trans("Dodawanie nowego pracownika");

$staff->redirectIfUnauthorized();

if (wasSentPost()) {

    $groups = isset($_POST['groups']) ? $_POST['groups'] : [];
    $staff_id = StaffModel::insert([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'avatar' => $_POST['avatar'],
    ], $groups);

    redirect('/admin/staff/list');
}

$groups = [];

require_once ACTIONS_PATH.'/admin/staff/form.html.php';
