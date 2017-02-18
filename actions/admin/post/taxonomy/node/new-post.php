<?php

$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'post-node',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

GC\Model\Post\Node::insertWithTaxonomyId([
    'frame_id' => $frame_id,
], $tax_id);

flashBox(trans('Nowy węzeł "%s" dostał dodany do "%s".', [post('name'), $taxonomy['name']]));

redirect($breadcrumbs->getLast('uri'));
