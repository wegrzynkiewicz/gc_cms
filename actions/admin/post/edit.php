<?php

$headTitle = trans("Edytowanie wpisu");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$post_id = intval(array_shift($_SEGMENTS));
$post = Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

if (wasSentPost()) {

    Frame::updateByFrameId($frame_id, [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    $relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

    Post::update($post_id, [], $relations);

    redirect('/admin/post/list');
}

$headTitle .= makeLink("/admin/post/list", $post['name']);

$_POST = $post;
$checkedValues = PostNode::selectAllAsOptionsPostId($post_id);

require_once ACTIONS_PATH.'/admin/post/form.html.php';
