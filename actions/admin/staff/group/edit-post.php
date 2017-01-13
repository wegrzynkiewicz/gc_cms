<?php

$group_id = intval(array_shift($_PARAMETERS));
GC\Model\Staff\Group::updateByPrimaryId($group_id, [
    'name' => post('name'),
]);
GC\Model\Staff\Group::updatePermissions($group_id, post('permissions'));

GC\Response::redirect($breadcrumbs->getLastUrl());
