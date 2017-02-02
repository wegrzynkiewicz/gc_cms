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
    'password' => GC\Auth\Password::hash($new_password),
    'regeneration' => json_encode([]),
]);

GC\Auth\Staff::createSession($user['staff_id']);
setNotice($trans('Zostałeś zalogowany, a Twoje hasło zostało zresetowane.'));

redirect('/admin');
