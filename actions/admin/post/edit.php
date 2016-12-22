<?php

$post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);
$headTitle = trans('Edytowanie wpisu "%s"', [$post['name']]);
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    GC\Model\Frame::updateByFrameId($post['frame_id'], [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    $relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

    GC\Model\Post::update($post_id, [], $relations);

    setNotice(trans('Wpis "%s" został zaktualizowany.', [$post['name']]));

    GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $post;
$checkedValues = array_keys(GC\Model\PostNode::mapNameByPostId($post_id));

require ACTIONS_PATH.'/admin/post/form.html.php';
