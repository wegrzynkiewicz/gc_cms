<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!$config['debug']['enabled']) {
    redirect('/');
}

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!GC\Staff::getInstance()['root']) {
    redirect('/');
}

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
