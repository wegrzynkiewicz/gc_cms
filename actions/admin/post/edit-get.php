<?php

$post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);
$headTitle = trans('Edytowanie wpisu "%s"', [$post['name']]);
$breadcrumbs->push($request->path, $headTitle);

$_POST = $post;
$checkedValues = array_keys(GC\Model\PostNode::mapNameByPostId($post_id));

require ACTIONS_PATH.'/admin/post/form.html.php';
