<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => $_POST['name'],
    'type' => 'post',
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => GC\Url::upload($_POST['image']),
]);

$relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

GC\Model\Post\Post::insertWithRelations([
    'frame_id' => $frame_id,
    'publication_datetime' => $_POST['publication_datetime'],
], $relations);

setNotice(trans('Nowy wpis "%s" została utworzony.', [$_POST['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
