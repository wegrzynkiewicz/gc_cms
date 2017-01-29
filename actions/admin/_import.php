<?php

/* Plik ładowany przed każdą akcją w panelu admina */

$session = new GC\Auth\StaffSession();
$session->start();
$session->redirectIfNonExists();
$config['instance']['session'] = $session;

# utworzenie obiektu reprezentującego pracownika
$staff = new GC\Auth\Staff();
$config['instance']['staff'] = $staff;

$uri->extendMask('/admin%s');

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'url' => $uri->mask(),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
$config['instance']['breadcrumbs'] = $breadcrumbs;
