<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!$config['debug']['enabled']) {
    redirect('/');
}

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = GC\Auth\Staff::createFromSession();
$config['instance']['staff'] = $staff;
/*
# stworzenie i weryfikacja tokenu CSRF
$tokenCSRF = new GC\Auth\CSRFToken();
GC\Data::set('tokenCSRF', $tokenCSRF);*/

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!$staff['root']) {
    redirect('/');
}

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => '/admin',
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
$breadcrumbs->push([
    'name' => 'Panel programisty',
    'icon' => 'bug',
]);
