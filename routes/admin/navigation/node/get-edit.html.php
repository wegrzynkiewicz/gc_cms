<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/_import.php";

$node_id = intval(array_shift($_PARAMETERS));

# pobranie węzła o zadanym kluczu
$node = GC\Model\Navigation\Node::select()
    ->fields('::withFrameFields, navigation_id')
    ->source('::withFrameSource')
    ->equals('node_id', $node_id)
    ->fetchObject();

$navigation_id = $node['navigation_id'];

require ROUTES_PATH."/admin/navigation/node/_import.php";

$headTitle = trans('Edycja węzła: %s', [$node->getName()]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $node->getData();
$nodeType = $node['type'];

require ROUTES_PATH."/admin/navigation/node/_form.html.php";
