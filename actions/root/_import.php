<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!GC\Data::get('config')['debug']['enabled']) {
    GC\Response::redirect('/');
}

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = GC\Auth\Staff::createFromSession();
GC\Data::set('staff', $staff);

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'url' => '/admin',
    'name' => 'Dashboard',
    'icon' => 'fa-dashboard',
]);
$breadcrumbs->push([
    'url' => null,
    'name' => 'Panel programisty',
    'icon' => 'fa-bug',
]);

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!$staff['root']) {
    GC\Response::redirect('/');
}
