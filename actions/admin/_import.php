<?php

/* Plik ładowany przed każdą akcją w panelu admina */

$staff = GC\Auth\Staff::createFromSession();
$config['instance']['staff'] = $staff;

$uri->extendMask('/admin%s');

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => $uri->mask('/'),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
$config['instance']['breadcrumbs'] = $breadcrumbs;
