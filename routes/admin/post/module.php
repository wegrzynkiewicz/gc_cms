<?php

$post = GC\Model\Post\Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

$headTitle = trans('Moduły w poście "%s"', [$post['name']]);
$uri->extendMask("/{$post_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);

$getPreviewUrl = function () use ($post_id) {
    return $uri->make("/post/{$post_id}");
};

require ROUTES_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
