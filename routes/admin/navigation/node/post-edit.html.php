<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/navigation/_import.php';

$node_id = intval(array_shift($_PARAMETERS));

GC\Model\Navigation\Node::updateByPrimaryId($node_id, [
    'name' => post('name'),
    'type' => post('type'),
    'theme' => post('theme', 'default'),
    'target' => post('target', '_self'),
    'frame_id' => post('frame_id', null),
    'destination' => post('destination', ''),
]);

# pobierz węzeł po kluczu głównym
$node = GC\Model\Navigation\Node::select()
    ->fields('::withFrameFields, navigation_id')
    ->source('::withFrameSource')
    ->equals('node_id', $node_id)
    ->fetchObject();

$navigation_id = $node['navigation_id'];

require ROUTES_PATH.'/admin/navigation/node/_import.php';

flashBox(trans('Węzeł nawigacji "%s" został zaktualizowany.', [$node->getName()]));
redirect($breadcrumbs->getLast('uri'));
