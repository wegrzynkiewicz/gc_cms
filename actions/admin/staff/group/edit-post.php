<?php

$permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
GC\Model\Staff\Group::update($group_id, [
    'name' => $_POST['name'],
], $permissions);

GC\Response::redirect($breadcrumbs->getLastUrl());
