<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!GC\Container::get('config')['debug']['enabled']) {
    GC\Response::redirect('/');
}

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = GC\Auth\Staff::createFromSession();
GC\Container::set('staff', $staff);

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', 'fa-dashboard');
$breadcrumbs->push(null, 'Panel programisty', 'fa-bug');

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!$staff['root']) {
    GC\Response::redirect('/');
}
