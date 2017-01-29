<?php

# dodaj ramkę do bazy
$frame_id = GC\Model\Module\Frame::insert([
    'name' => post('name'),
    'type' => 'product',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload($_POST['image']),
]);

# dodaj produkt do bazy
$product_id = GC\Model\Product\Product::insert([
    'frame_id' => intval($frame_id),
]);

# spłaszcz nadesłane przynależności do węzłów taksonomii
$nodes = array_unchunk(post('taxonomy', []));

# wstaw przynależności produktu do węzłów taksonomii
foreach ($nodes as $node_id) {
    GC\Model\Product\Membership::insert([
        'product_id' => intval($product_id),
        'node_id' => intval($node_id),
    ]);
}

setNotice($trans('Nowy wpis "%s" została utworzony.', [$_POST['name']]));
redirect($breadcrumbs->getLast('url'));
