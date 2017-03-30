<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/account/_import.php";

$newPassword = post('new_password');

# pobranie klucza głównego zalogowanego pracownika
$staff_id = GC\Staff::getInstance()['staff_id'];

# zaktualizuj hasło zalogowanego pracownika
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'password' => password_hash($newPassword, \PASSWORD_DEFAULT),
]);

flashBox(trans('Twoje hasło zostało zmienione.'));
redirect($breadcrumbs->getLast()['uri']);
