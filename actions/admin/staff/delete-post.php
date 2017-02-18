<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';

$staff_id = post('staff_id');

# pobierz pracownika po kluczu głównym
$user = GC\Model\Staff\Staff::fetchByPrimaryId($staff_id);

# usuń pracownika po kluczu głównym
GC\Model\Staff\Staff::deleteByPrimaryId($staff_id);

flashBox(trans('Pracownik "%s" został usunięty.', [$user['name']]));
redirect($breadcrumbs->getLast('uri'));
