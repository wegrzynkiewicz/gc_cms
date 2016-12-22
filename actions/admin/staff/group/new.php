<?php

$headTitle = trans("Dodawanie nowej grupy pracowników");
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    $group_id = GC\Model\StaffGroup::insertWithPermissions([
        'name' => $_POST['name'],
    ], $permissions);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$permissions = [];

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
