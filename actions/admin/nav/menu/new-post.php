<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = GC\Model\Menu\Menu::insert([
    'name' => post('name'),
    'type' => post('type'),
    'destination' => post('destination'),
    'target' => post('target', '_self'),
]);

# pobierz największą pozycję dla węzła w drzewie
$position = GC\Model\Menu\Tree::select()
    ->fields('MAX(position) AS max')
    ->equals('nav_id', $nav_id)
    ->equals('parent_id', null)
    ->fetch()['max'];

GC\Model\Menu\Tree::insert([
    'nav_id' => $nav_id,
    'menu_id' => $menu_id,
    'parent_id' => null,
    'position' => $position + 1,
]);

redirect($breadcrumbs->getLast('uri'));
