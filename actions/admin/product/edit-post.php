<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';

$product_id = intval(array_shift($_PARAMETERS));

# pobranie produktu wraz z ramką po $product_id
$product = GC\Model\Product\Product::select()
    ->source('::frame')
    ->equals('product_id', $product_id)
    ->fetch();

# zaktualizuj ramkę po frame_id
GC\Model\Frame::update()
    ->set([
        'name' => post('name'),
        'keywords' => post('keywords'),
        'description' => post('description'),
        'image' => $uri->upload(post('image')),
    ])
    ->equals('frame_id', $product['frame_id'])
    ->execute();

# spłaszcz nadesłane przynależności do węzłów taksonomii
$nodes = array_unchunk(post('taxonomy', []));

# wstaw przynależności produktu do węzłów taksonomii
foreach ($nodes as $node_id) {
    GC\Model\Product\Membership::insert([
        'product_id' => intval($product_id),
        'node_id' => intval($node_id),
    ]);
}

setNotice($trans('Produkt "%s" został zaktualizowany.', [$product['name']]));
redirect($breadcrumbs->getLast('uri'));
