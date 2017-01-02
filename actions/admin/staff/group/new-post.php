<?php

$permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
$group_id = GC\Model\Staff\Group::insertWithPermissions([
    'name' => $_POST['name'],
], $permissions);

GC\Response::redirect($breadcrumbs->getLastUrl());
