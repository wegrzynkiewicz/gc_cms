<?php

require ROUTES_PATH."/auth/_import.php";

$newPassword = $_POST['new_password'];

// pobranie klucza głównego zalogowanego pracownika
$staff_id = $_SESSION['staff']['staff_id'];

// zaktualizuj dane pracownika
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'password' => password_hash($newPassword, \PASSWORD_DEFAULT),
    'force_change_password' => 0,
]);

flashBox(trans('Twoje hasło zostało zmienione.'));
redirect($uri->make('/admin'));
