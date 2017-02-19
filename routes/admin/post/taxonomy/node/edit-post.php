<?php

$node = GC\Model\Post\Node::selectWithFrameByPrimaryId($node_id);

GC\Model\Frame::updateByFrameId($node['frame_id'], [
    'name' => post('name'),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

flashBox(trans('Węzeł "%s" został zaktualizowany.', [$node['name']]));

redirect($breadcrumbs->getLast('uri'));