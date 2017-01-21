<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => post('name'),
    'type' => 'post',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => GC\Url::upload($_POST['image']),
]);

$relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

GC\Model\Post\Post::insertWithRelations([
    'frame_id' => $frame_id,
    'publication_datetime' => post('publication_datetime'),
], $relations);

setNotice($trans('Nowy wpis "%s" została utworzony.', [$_POST['name']]));
redirect($breadcrumbs->getLast('url'));
