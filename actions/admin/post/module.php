<?php

require_once ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);
$post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);
$frame_id = $post['frame_id'];

$getPreviewUrl = function() use ($post_id) {
    return url("/post/{$post_id}");
};

$surl = function($path) use ($surl, $post_id) {
    return $surl("/{$post_id}/module{$path}");
};

$headTitle = trans('Moduły w poście "%s"', [$post['name']]);
$breadcrumbs->push($surl("/list"), $headTitle);

require_once ACTIONS_PATH."/admin/parts/module/$action.html.php";
