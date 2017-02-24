<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/account/_import.php';

# pobranie klucza głównego zalogowanego pracownika
$staff_id = GC\Staff::getInstance()['staff_id'];

# zaktualizuj profil pracownika
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'lang' => post('lang'),
]);

flashBox(trans('Twój profil został zaktualizowany.'));
redirect($breadcrumbs->getLast('uri'));
