<?php

require ACTIONS_PATH.'/auth/_import.php';
require ACTIONS_PATH.'/auth/forgot/_import.php';

# utworzenie obiektu repezentującego pracownika
$staff = GC\Auth\Staff::createFromSession();

$new_password = post('new_password');

GC\Model\Staff\Staff::updateByPrimaryId($staff['staff_id'], [
    'password' => password_hash($new_password, \PASSWORD_DEFAULT),
]);

GC\Model\Staff\Meta::deleteMeta($staff['staff_id'], [
    'regenerationVerifyHash',
    'regenerationVerifyTime',
]);

flashBox($trans('Zostałeś zalogowany, a Twoje hasło zostało zresetowane.'));
redirect('/admin');
