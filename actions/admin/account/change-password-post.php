<?php

$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

$user = GC\Model\Staff\Staff::selectByPrimaryId($_SESSION['staff']['entity']['staff_id']);

if (strlen($newPassword) < $config['password']['minLength']) {
    $error = trans('Hasło nie może być krótsze niż %s znaków', $config['password']['minLength']);

    return require ACTIONS_PATH.'/admin/account/change-password-get.php';
}

if (!GC\Password::verify($oldPassword, $user['password'])) {
    $error = trans('Stare hasło nie zgadza się z obecnym hasłem');

    return require ACTIONS_PATH.'/admin/account/change-password-get.php';
}

if ($newPassword !== $confirmPassword) {
    $error = trans('Podane nowe hasła nie są identyczne');

    return require ACTIONS_PATH.'/admin/account/change-password-get.php';
}

GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
    'password' => GC\Password::hash($newPassword),
]);

setNotice(trans("Twoje hasło zostało zmienione"));

GC\Response::redirect($breadcrumbs->getLastUrl());
