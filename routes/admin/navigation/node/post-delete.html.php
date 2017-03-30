<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/navigation/_import.php';

$node_id = intval(post('node_id'));

# pobierz węzeł po kluczu głównym
$node = GC\Model\Navigation\Node::select()
    ->source('::withFrameFields')
    ->source('::withFrameSource')
    ->equals('node_id', $node_id)
    ->fetchObject();

$navigation_id = $node['navigation_id'];

require ROUTES_PATH.'/admin/navigation/node/_import.php';

# usuń węzeł i podwęzły nawigacji
GC\Model\Navigation\Node::deleteBynodeId($node_id);

flashBox(trans('Węzeł nawigacji "%s" i wszystkie jego podwęzły zostały usunięte.', [$node->getName()]));
redirect($breadcrumbs->getLast()['uri']);
