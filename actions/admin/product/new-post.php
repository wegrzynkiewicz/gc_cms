<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';

# dodaj ramkę do bazy
$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'product',
    'lang' => GC\Staff::getInstance()->getEditorLang(),
    'slug' => empty(post('slug')) ? '' : makeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload(post('image')),
]);

# spłaszcz nadesłane przynależności do węzłów taksonomii
$nodes = array_unchunk(post('taxonomy', []));

# wstaw przynależności produktu do węzłów taksonomii
foreach ($nodes as $node_id) {
    GC\Model\Product\Membership::insert([
        'frame_id' => $frame_id,
        'node_id' => intval($node_id),
    ]);
}

flashBox($trans('Nowy produkt "%s" została utworzony.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
