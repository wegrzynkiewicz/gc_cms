<?php

$post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);

GC\Model\Frame::updateByFrameId($post['frame_id'], [
    'name' => $_POST['name'],
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => $_POST['image'],
]);

$relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

GC\Model\Post::update($post_id, [
    'publication_datetime' => $_POST['publication_datetime'],
], $relations);

setNotice(trans('Wpis "%s" został zaktualizowany.', [$post['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
