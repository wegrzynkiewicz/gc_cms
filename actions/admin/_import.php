<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# utworzenie obiektu repezentującego pracownika
$staff = GC\Auth\Staff::createFromSession();

# weryfikacja tokenu CSRF
GC\Auth\CSRFToken::routines($request);

$uri->extendMask('/admin%s');

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => $uri->mask('/'),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
