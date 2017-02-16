<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/node/_import.php';

$node_id = intval(array_shift($_PARAMETERS));

# pobierz węzeł razem z ramką o $node_id
$node = GC\Model\Product\Node::select()
    ->fields(['frame_id', 'name'])
    ->source('::frame')
    ->equals('node_id', $node_id)
    ->fetch();

# zaktualizuj ramkę po frame_id
GC\Model\Frame::update()
    ->set([
        'name' => post('name'),
        'keywords' => post('keywords'),
        'description' => post('description'),
        'image' => $uri->upload(post('image')),
    ])
    ->equals('frame_id', $node['frame_id'])
    ->execute();

flashBox($trans('Węzeł "%s" został zaktualizowany.', [$node['name']]));
redirect($breadcrumbs->getLast('uri'));
