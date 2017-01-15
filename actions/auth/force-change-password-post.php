<?php

$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

$user = GC\Model\Staff\Staff::fetchByPrimaryId($_SESSION['staff']['staff_id']);

if ($newPassword !== $confirmPassword) {
    $error = $trans('Podane nowe hasła nie są identyczne');

    return require ACTIONS_PATH.'/admin/account/force-change-password-get.php';
}

if (strlen($newPassword) < $config['password']['minLength']) {
    $error = $trans('Hasło nie może być krótsze niż %s znaków', $config['password']['minLength']);

    return require ACTIONS_PATH.'/admin/account/force-change-password-get.php';
}

if (GC\Auth\Password::verify($newPassword, $user['password'])) {
    $error = $trans('Nowe hasło nie może być takie samo jak poprzednie');

    return require ACTIONS_PATH.'/admin/account/force-change-password-get.php';
}

GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
    'password' => GC\Auth\Password::hash($newPassword),
    'force_change_password' => 0,
]);

setNotice($trans('Twoje hasło zostało zmienione.'));

GC\Response::redirect('/admin');
