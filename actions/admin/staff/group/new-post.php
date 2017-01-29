<?php

$permissions = post('permissions', []);
$group_id = GC\Model\Staff\Group::insert([
    'name' => post('name'),
]);
GC\Model\Staff\Group::updatePermissions($group_id, $permissions);

redirect($breadcrumbs->getLast('uri'));
