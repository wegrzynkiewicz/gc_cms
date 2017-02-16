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

GC\Model\Menu\Tree::insert([
    'nav_id' => $nav_id,
    'menu_id' => $menu_id,
    'parent_id' => null,
    'position' => GC\Model\Menu\Tree::selectMaxPositionByTaxonomyIdAndParentId($nav_id, null),
]);

redirect($breadcrumbs->getLast('uri'));
