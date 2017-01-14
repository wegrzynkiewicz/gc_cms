<?php

/* Plik ładowany przed każdą akcją w panelu admina */

GC\Url::extendMask('/admin%s');

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'href' => '/admin',
    'name' => 'Dashboard',
    'icon' => 'fa-dashboard',
]);

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
GC\Data::set('staff', GC\Auth\Staff::createFromSession());
