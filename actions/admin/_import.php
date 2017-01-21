<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
GC\Auth\Staff::startSession();
$staff = GC\Auth\Staff::createFromSession();
GC\Data::set('staff', $staff);

# stworzenie i weryfikacja tokenu CSRF
$tokenCSRF = new GC\Auth\CSRFToken();
GC\Data::set('tokenCSRF', $tokenCSRF);

GC\Url::extendMask('/admin%s');

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'url' => GC\Url::mask(),
    'name' => 'Dashboard',
    'icon' => 'fa-dashboard',
]);
GC\Data::set('breadcrumbs', $breadcrumbs);
