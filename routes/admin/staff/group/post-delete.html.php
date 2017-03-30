<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/staff/_import.php';
require ROUTES_PATH.'/admin/staff/group/_import.php';

$group_id = intval(post('group_id'));

# pobierz grupę po kluczu głównym
$group = GC\Model\Staff\Group::fetchByPrimaryId($group_id);

# usuń grupę pracowników
GC\Model\Staff\Group::deleteByPrimaryId($group_id);

flashBox(trans('Grupa pracowników "%s" została usunięta.', [$group['name']]));
redirect($breadcrumbs->getLast('uri'));
