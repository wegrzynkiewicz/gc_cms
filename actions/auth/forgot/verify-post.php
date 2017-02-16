<?php

require ACTIONS_PATH.'/auth/forgot/verify-validate.html.php';

if (isset($error)) {
    redirect('/auth/login');
}

$new_password = post('new_password');

if ($new_password !== post('confirm_password')) {
    redirect('/auth/login');
}

GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
    'password' => password_hash($new_password, \PASSWORD_DEFAULT),
    'regeneration' => json_encode([]),
]);

GC\Auth\Staff::createSession($user['staff_id']);
flashBox($trans('Zostałeś zalogowany, a Twoje hasło zostało zresetowane.'));

redirect('/admin');
