<?php

$action = array_shift($_SEGMENTS);
$post_id = intval(array_pop($_SEGMENTS));

$post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

$getPreviewUrl = function() use ($post_id) {
    return url("/post/$post_id");
};

$getModuleUrl = function($path) use ($post_id) {
    return url("/admin/post/module$path/$post_id");
};

$headTitle = trans('Moduły w poście "%s"', [$post['name']]);
$breadcrumbs->push($getModuleUrl("/list"), $headTitle);

require_once ACTIONS_PATH."/admin/parts/module/$action.html.php";
