<?php

$headTitle = trans("Dodawanie nowej grupy pracowników");
$breadcrumbs->push($request, $headTitle);

if (wasSentPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    $group_id = GC\Model\StaffGroup::insert([
        'name' => $_POST['name'],
    ], $permissions);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$permissions = [];

require_once ACTIONS_PATH.'/admin/staff/group/form.html.php';
