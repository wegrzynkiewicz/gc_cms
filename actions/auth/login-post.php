<?php


if (isset($_SESSION['staff'])) {
    GC\Response::redirect('/admin');
}

$user = GC\Model\Staff\Staff::select()->equals('email', $_POST['email'])->fetch();
if (!$user) {
    $error = trans('Nieprawidłowy login lub hasło');

    return require ACTIONS_PATH.'/auth/login-get.php';
}

$password = $_POST['password'];

# jeżeli hasło w bazie nie jest zahaszowane, a zgadza się
if ($config['debug']['enabled'] and $user and $password === $user['password']) {
    $newPasswordHash = GC\Auth\Password::hash($password);
    GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
        'password' => $newPasswordHash,
    ]);
    $user['password'] = $newPasswordHash;
}

if (!GC\Auth\Password::verify($password, $user['password'])) {
    $error = trans('Nieprawidłowy login lub hasło');

    return require ACTIONS_PATH.'/auth/login-get.php';
}

if (password_needs_rehash($user['password'], PASSWORD_DEFAULT, $config['password']['options'])) {
    GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
        'password' => GC\Auth\Password::hash($password),
    ]);
}

$_SESSION['staff'] = [
    'entity' => $user,
    'sessionTimeout' => time() + $config['session']['staffTimeout']
];

GC\Storage\Dump::makeBackup(sprintf('Po zalogowaniu użytkownika %s', $user['name']));
GC\Response::redirect('/admin');
