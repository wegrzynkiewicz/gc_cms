<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => post('name'),
    'type' => 'post-node',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload($_POST['image']),
]);

GC\Model\Post\Node::insertWithTaxonomyId([
    'frame_id' => $frame_id,
], $tax_id);

setNotice($trans('Nowy węzeł "%s" dostał dodany do "%s".', [$_POST['name'], $taxonomy['name']]));

redirect($breadcrumbs->getLast('uri'));
