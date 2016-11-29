<?php

$headTitle = trans("Nowy moduł w poście");

$staff->redirectIfUnauthorized();

$post_id = intval(array_shift($_SEGMENTS));
$post = Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

if(wasSentPost()) {
	FrameModule::insert([
        'type' => $_POST['type'],
    ], $frame_id);

	redirect("/admin/post/module/list/$post_id");
}

$headTitle .= makeLink("/admin/post/module/$post_id", $post['name']);

require_once ACTIONS_PATH.'/admin/module/new.html.php'; ?>
