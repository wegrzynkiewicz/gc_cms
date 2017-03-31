<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/_import.php";

$navigation_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/navigation/node/_import.php";

$node_id = GC\Model\Navigation\Node::insert([
    'name' => post('name'),
    'type' => post('type'),
    'theme' => post('theme', 'default'),
    'target' => post('target', '_self'),
    'frame_id' => post('frame_id', null),
    'destination' => post('destination', ''),
]);

// pobierz największą pozycję dla węzła w drzewie
$position = GC\Model\Navigation\Tree::select()
    ->fields('MAX(position) AS max')
    ->equals('navigation_id', $navigation_id)
    ->equals('parent_id', null)
    ->fetch()['max'];

GC\Model\Navigation\Tree::insert([
    'navigation_id' => $navigation_id,
    'node_id' => $node_id,
    'parent_id' => null,
    'position' => $position + 1,
]);

// pobierz węzeł po kluczu głównym
$node = GC\Model\Navigation\Node::select()
    ->fields('::withFrameFields')
    ->source('::withFrameSource')
    ->equals('node_id', $node_id)
    ->fetchObject();

flashBox(trans('Węzeł nawigacji "%s" został utworzony.', [$node->getName()]));
redirect($breadcrumbs->getLast()['uri']);
