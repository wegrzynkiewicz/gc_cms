<?php

require ROUTES_PATH.'/auth/_import.php';

# pobranie klucza głównego zalogowanego pracownika
$staff_id = GC\Staff::getInstance()['staff_id'];

$new_password = post('new_password');

GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'password' => password_hash($new_password, \PASSWORD_DEFAULT),
]);

GC\Model\Staff\Meta::deleteMeta($staff_id, [
    'regenerationVerifyHash',
    'regenerationVerifyTime',
]);

flashBox(trans('Zostałeś zalogowany, a Twoje hasło zostało zresetowane.'));
redirect($uri->make('/admin'));
