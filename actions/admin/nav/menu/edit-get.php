<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = intval(array_shift($_PARAMETERS));

# pobranie węzła o zadanym kluczu
$node = GC\Model\Menu\Menu::select()
    ->equals('menu_id', $menu_id)
    ->fetch();

$headTitle = $trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

$_POST = $node;
$refreshUrl = $uri->mask("/{$menu_id}/edit-views");

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
