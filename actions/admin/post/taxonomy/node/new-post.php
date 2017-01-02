<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => $_POST['name'],
    'type' => 'post-node',
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => GC\Url::upload($_POST['image']),
]);

GC\Model\Post\Node::insertWithTaxonomyId([
    'frame_id' => $frame_id,
], $tax_id);

setNotice(trans('Nowy węzeł "%s" dostał dodany do "%s".', [$_POST['name'], $taxonomy['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
