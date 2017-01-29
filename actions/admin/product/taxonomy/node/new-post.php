<?php

$name = post('name');

# wstaw ramkę do bazy z podstawowymi danymi
$frame_id = GC\Model\Module\Frame::insert([
    'name' => $name,
    'type' => 'product-node',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload($_POST['image']),
]);

# dodaj węzeł
$node_id = GC\Model\Product\Node::insert([
    'frame_id' => $frame_id,
]);

# dodaj węzeł do pozycji w drzewie taksonomi
GC\Model\Product\Tree::insert([
    'tax_id' => $tax_id,
    'node_id' => $node_id,
    'parent_id' => null,
    'position' => GC\Model\Product\Tree::selectMaxPositionByTaxonomyIdAndParentId($tax_id, null),
]);

setNotice($trans('Nowy węzeł "%s" dostał dodany do "%s".', [$name, $taxonomy['name']]));
redirect($breadcrumbs->getLast('url'));
