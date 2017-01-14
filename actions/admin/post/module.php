<?php

$post = GC\Model\Post\Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

$headTitle = $trans('Moduły w poście "%s"', [$post['name']]);
GC\Url::extendMask("/{$post_id}/module%s");
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
]);

$getPreviewUrl = function () use ($post_id) {
    return GC\Url::make("/post/{$post_id}");
};

require ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
