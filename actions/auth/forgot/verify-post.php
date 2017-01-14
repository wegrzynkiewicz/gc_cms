<?php

require_once ACTIONS_PATH.'/auth/forgot/verify-validate.html.php';

if (isset($error)) {
    GC\Response::redirect('/auth/login');
}

$new_password = $_POST['new_password'];

if ($new_password !== $_POST['confirm_password']) {
    GC\Response::redirect('/auth/login');
}

GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
    'password' => GC\Auth\Password::hash($new_password),
    'regeneration' => json_encode([]),
]);

$_SESSION['staff'] = [
    'entity' => $user,
    'sessionTimeout' => time() + GC\Data::get('config')['session']['staffTimeout']
];

setNotice($trans('Zostałeś zalogowany, a Twoje hasło zostało zresetowane.'));

GC\Response::redirect('/admin');
