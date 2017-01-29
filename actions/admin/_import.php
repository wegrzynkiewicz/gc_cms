<?php

/* Plik ładowany przed każdą akcją w panelu admina */

$session = new GC\Auth\StaffSession();
$session->start();
$session->redirectIfNonExists();
GC\Data::set('session', $session);

# utworzenie obiektu reprezentującego pracownika
$staff = new GC\Auth\Staff();
GC\Data::set('staff', $staff);

GC\Url::extendMask('/admin%s');

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'url' => GC\Url::mask(),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
GC\Data::set('breadcrumbs', $breadcrumbs);
