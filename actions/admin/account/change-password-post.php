<?php

$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

$staff_id = GC\Data::get('staff')['staff_id'];
$user = GC\Model\Staff\Staff::fetchByPrimaryId($staff_id);

if (strlen($newPassword) < $config['password']['minLength']) {
    $error = $trans('Hasło nie może być krótsze niż %s znaków', $config['password']['minLength']);

    return require ACTIONS_PATH.'/admin/account/change-password-get.php';
}

if (!GC\Auth\Password::verify($oldPassword, $user['password'])) {
    $error = $trans('Stare hasło nie zgadza się z obecnym hasłem');

    return require ACTIONS_PATH.'/admin/account/change-password-get.php';
}

if ($newPassword !== $confirmPassword) {
    $error = $trans('Podane nowe hasła nie są identyczne');

    return require ACTIONS_PATH.'/admin/account/change-password-get.php';
}

GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
    'password' => GC\Auth\Password::hash($newPassword),
]);

setNotice($trans("Twoje hasło zostało zmienione"));

GC\Response::redirect($breadcrumbs->getLast('url'));
