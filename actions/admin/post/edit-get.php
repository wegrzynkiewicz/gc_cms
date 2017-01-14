<?php

$post_id = intval(array_shift($_PARAMETERS));
$post = GC\Model\Post\Post::selectWithFrameByPrimaryId($post_id);
$headTitle = $trans('Edytowanie wpisu "%s"', [$post['name']]);
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$_POST = $post;
$checkedValues = array_keys(GC\Model\Post\Node::mapNameByPostId($post_id));

require ACTIONS_PATH.'/admin/post/form.html.php';
