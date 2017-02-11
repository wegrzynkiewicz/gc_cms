<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';
require ACTIONS_PATH.'/admin/staff/group/_import.php';

$group_id = intval(array_shift($_PARAMETERS));
GC\Model\Staff\Group::updateByPrimaryId($group_id, [
    'name' => post('name'),
]);
GC\Model\Staff\Group::updatePermissions($group_id, post('permissions'));

redirect($breadcrumbs->getLast('uri'));
