<?php

GC\Translator::$domain = 'admin';

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push([
    'uri' => $uri->make('/admin'),
    'name' => 'Dashboard',
    'icon' => 'dashboard',
]);
$breadcrumbs->push([
    'name' => 'Panel programisty',
    'icon' => 'bug',
]);
