<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = GC\Model\Menu\Menu::insert([
    'name' => post('name'),
    'type' => post('type'),
    'destination' => post('destination', ''),
    'target' => post('target', '_self'),
    'frame_id' => post('frame_id', null),
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

# pobierz węzeł po kluczu głównym
$menu = GC\Model\Menu\Menu::select()
    ->fields('::fields')
    ->source('::tree_frame')
    ->equals('menu_id', $menu_id)
    ->fetchObject();

flashBox($trans('Menu "%s" zostało utworzone.', [$menu->getName()]));
redirect($breadcrumbs->getLast('uri'));
