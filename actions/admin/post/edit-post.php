<?php

$post = GC\Model\Post\Post::selectWithFrameByPrimaryId($post_id);

GC\Model\Module\Frame::updateByFrameId($post['frame_id'], [
    'name' => post('name'),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => post('image'),
]);

$relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

GC\Model\Post\Post::update($post_id, [
    'publication_datetime' => post('publication_datetime'),
], $relations);

setNotice($trans('Wpis "%s" został zaktualizowany.', [$post['name']]));

GC\Response::redirect($breadcrumbs->getLast('url'));