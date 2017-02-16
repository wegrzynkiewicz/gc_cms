<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# utworzenie obiektu repezentującego pracownika
$staff = GC\Auth\Staff::createFromSession();

$uri->extendMask('/admin%s');
$translator->domain = 'admin';

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => $uri->mask('/'),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
