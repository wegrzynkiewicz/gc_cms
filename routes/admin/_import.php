<?php

/* Plik ładowany przed każdą akcją w panelu admina */

$_SESSION['staff']['staff_id'] = 1;

# utworzenie obiektu repezentującego pracownika
GC\Staff::getInstance();

$uri->extendMask('/admin%s');
GC\Translator::$domain = 'admin';

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => $uri->mask(''),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
