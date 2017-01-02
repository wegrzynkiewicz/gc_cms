<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => $_POST['name'],
    'type' => 'page',
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => GC\Url::upload($_POST['image']),
]);

GC\Model\Page::insert([
    'frame_id' => $frame_id,
]);

setNotice(trans('Nowa strona "%s" została utworzona.', [$_POST['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
