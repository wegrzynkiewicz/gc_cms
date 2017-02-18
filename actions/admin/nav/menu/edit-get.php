<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = intval(array_shift($_PARAMETERS));

# pobranie węzła o zadanym kluczu
$node = GC\Model\Menu\Menu::select()
    ->fields('::fields')
    ->source('::tree_frame')
    ->equals('menu_id', $menu_id)
    ->fetchObject();

$headTitle = $trans('Edycja węzła "%s"', [$node->getName()]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $node;
$type = $node['type'];
$nodeType = render(ACTIONS_PATH."/admin/nav/menu/types/{$type}.php", $node->getData());

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
