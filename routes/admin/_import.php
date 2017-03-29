<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# utworzenie obiektu repezentującego pracownika
$staff = GC\Staff::getInstance();

GC\Translator::$domain = 'admin';

# utworzenie okruszków chleba dla całego panelu admina
$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => $uri->make('/'),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
