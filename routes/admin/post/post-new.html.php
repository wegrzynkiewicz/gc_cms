<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';

# dodaj ramkę do bazy
$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'post',
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

# spłaszcz nadesłane przynależności do węzłów taksonomii
$nodes = array_unchunk(post('taxonomy', []));

# wstaw przynależności wpisu do węzłów taksonomii
foreach ($nodes as $node_id) {
    GC\Model\Post\Membership::insert([
        'frame_id' => $frame_id,
        'node_id' => intval($node_id),
    ]);
}

flashBox(trans('Nowy produkt "%s" została utworzony.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
