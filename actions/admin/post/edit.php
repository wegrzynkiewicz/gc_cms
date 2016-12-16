<?php

$headTitle = trans("Edytowanie wpisu");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$post_id = intval(array_shift($_SEGMENTS));
$post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

if (isPost()) {

    GC\Model\Frame::updateByFrameId($frame_id, [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    $relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

    GC\Model\Post::update($post_id, [], $relations);

    redirect('/admin/post/list');
}

$headTitle .= makeLink("/admin/post/list", $post['name']);

$_POST = $post;
$checkedValues = GC\Model\PostNode::selectAllAsOptionsPostId($post_id);

require_once ACTIONS_PATH.'/admin/post/form.html.php';
