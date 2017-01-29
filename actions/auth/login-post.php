<?php

if (GC\Auth\Staff::existsSessionCookie()) {
    redirect('/admin');
}

$password = post('password');

$user = GC\Model\Staff\Staff::select()
    ->equals('email', $_POST['email'])
    ->fetch();

# jeżeli hasło w bazie nie jest zahaszowane, a zgadza się
if ($config['debug']['enabled'] and $user and $password === $user['password']) {
    $newPasswordHash = hashPassword($password);
    GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
        'password' => $newPasswordHash,
    ]);
    $user['password'] = $newPasswordHash;
}

if (!$user or !verifyPassword($password, $user['password'])) {
    $error = $trans('Nieprawidłowy login lub hasło');

    return require ACTIONS_PATH.'/auth/login-get.php';
}

if (passwordNeedsRehash($user['password'])) {
    GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
        'password' => hashPassword($password),
    ]);
}

GC\Auth\Staff::createSession($user['staff_id']);

GC\Storage\Backup::make(sprintf('Po zalogowaniu użytkownika %s', $user['name']));
redirect('/admin');
