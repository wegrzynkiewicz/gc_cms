<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

GC\Model\Frame::updateByFrameId($frame_id, [
    'name' => post('name'),
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

# spłaszcz nadesłane przynależności do węzłów taksonomii
$nodes = array_unchunk(post('taxonomy', []));

# usuń wszyskie przynależności produktu
GC\Model\Product\Membership::delete()
    ->equals('frame_id', $frame_id)
    ->execute();

# wstaw przynależności produktu do węzłów taksonomii
foreach ($nodes as $node_id) {
    GC\Model\Product\Membership::insert([
        'frame_id' => intval($frame_id),
        'node_id' => intval($node_id),
    ]);
}

flashBox($trans('Produkt "%s" został zaktualizowany.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
