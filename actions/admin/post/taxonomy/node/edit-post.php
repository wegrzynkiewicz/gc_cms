<?php

$node = GC\Model\Post\Node::selectWithFrameByPrimaryId($node_id);

GC\Model\Module\Frame::updateByFrameId($node['frame_id'], [
    'name' => $_POST['name'],
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => GC\Url::upload($_POST['image']),
]);

setNotice($trans('Węzeł "%s" został zaktualizowany.', [$node['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
