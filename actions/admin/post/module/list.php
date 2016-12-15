<?php

$headTitle = trans("Moduły w poście");

$staff->redirectIfUnauthorized();

$parent_id = intval(array_shift($_SEGMENTS));
$post = GrafCenter\CMS\Model\Post::selectWithFrameByPrimaryId($parent_id);
$frame_id = $post['frame_id'];

$headTitle .= makeLink("/admin/page/list", $post['name']);

require_once ACTIONS_PATH.'/admin/parts/module/list.html.php'; ?>
