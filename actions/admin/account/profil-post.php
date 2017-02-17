<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/account/_import.php';

$staff_id = $staff['staff_id'];

# zaktualizuj profil pracownika
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'lang' => post('lang'),
]);

flashBox($trans('Twój profil został zaktualizowany.'));
redirect($breadcrumbs->getBeforeLast('uri'));
