<?php

$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'post',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

$relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

GC\Model\Post\Post::insertWithRelations([
    'frame_id' => $frame_id,
    'publication_datetime' => post('publication_datetime'),
], $relations);

flashBox(trans('Nowy wpis "%s" została utworzony.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
