<?php

require ACTIONS_PATH.'/auth/_import.php';

if (isset($_SESSION['staff'])) {
    redirect('/admin');
}

$password = post('password');

# pobierz pracownika po adresie email
$user = GC\Model\Staff\Staff::select()
    ->equals('email', post('login'))
    ->fetch();

# jeżeli debug włączony i hasło w bazie nie jest zahaszowane, a zgadza się
if ($config['debug']['enabled'] and $user and $password === $user['password']) {
    # zaktualizuj hasło pracownika na hash
    GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
        'password' => password_hash($password, \PASSWORD_DEFAULT),
    ]);
}
# jeżeli użytkownik nie istnieje, albo hasło jest nieprawidłowe
elseif (!$user or !password_verify($password, $user['password'])) {
    return display(ACTIONS_PATH.'/auth/login-get.php', [
        'error' => $trans('Nieprawidłowy login lub hasło'),
    ]);
}

# ustawienie sesji pracownika
$_SESSION['staff']['staff_id'] = $user['staff_id'];

GC\Storage\Backup::make(sprintf('Po zalogowaniu użytkownika %s', $user['name']));
redirect('/admin');
