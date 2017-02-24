<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/nav/_import.php';
require ROUTES_PATH.'/admin/nav/menu/_import.php';

$menu_id = intval($_POST['menu_id']);

# pobierz węzeł po kluczu głównym
$menu = GC\Model\Menu\Menu::select()
    ->source('::tree_frame')
    ->equals('menu_id', $menu_id)
    ->fetchObject();

# usuń węzeł i podwęzły nawigacji
GC\Model\Menu\Menu::deleteByMenuId($menu_id);

flashBox(trans('Menu "%s" zostało usunięte.', [$menu->getName()]));
redirect($breadcrumbs->getLast('uri'));
