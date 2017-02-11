<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';
require ACTIONS_PATH.'/admin/staff/group/_import.php';

$permissions = post('permissions', []);
$group_id = GC\Model\Staff\Group::insert([
    'name' => post('name'),
]);
GC\Model\Staff\Group::updatePermissions($group_id, $permissions);

redirect($breadcrumbs->getLast('uri'));
