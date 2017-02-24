<?php

require ROUTES_PATH.'/auth/_import.php';

if (isset($_SESSION['staff'])) {
    redirect('/admin');
}

$password = post('password');

# pobierz pracownika po adresie email
$user = GC\Model\Staff\Staff::select()
    ->equals('email', post('login'))
    ->fetch();

# jeżeli użytkownik nie istnieje, albo hasło jest nieprawidłowe
if (!$user or !password_verify($password, $user['password'])) {
    return display(ROUTES_PATH.'/auth/login-get.php', [
        'error' => trans('Nieprawidłowy login lub hasło'),
    ]);
}

# ustawienie sesji pracownika
$_SESSION['staff']['staff_id'] = $user['staff_id'];

GC\Storage\Backup::make(sprintf('Po zalogowaniu użytkownika %s', $user['name']));
redirect('/admin');
