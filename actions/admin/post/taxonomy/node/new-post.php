<?php

$frame_id = GC\Model\Frame::insert([
    'name' => $_POST['name'],
    'type' => 'post-node',
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => GC\Url::upload($_POST['image']),
]);

GC\Model\PostNode::insertWithTaxonomyId([
    'frame_id' => $frame_id,
], $tax_id);

setNotice(trans('Nowy węzeł "%s" dostał dodany do "%s".', [$_POST['name'], $taxonomy['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
