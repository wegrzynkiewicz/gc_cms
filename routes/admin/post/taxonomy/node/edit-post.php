<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/node/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz węzeł o $frame_id
$node = GC\Model\Post\Tree::select()
    ->fields(['frame_id', 'name'])
    ->source('::nodes')
    ->equals('frame_id', $frame_id)
    ->fetch();

# zaktualizuj ramkę po frame_id
GC\Model\Frame::updateByFrameId($frame_id, [
    'name' => post('name'),
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

flashBox(trans('Węzeł "%s" został zaktualizowany.', [$node['name']]));
redirect($breadcrumbs->getLast('uri'));
