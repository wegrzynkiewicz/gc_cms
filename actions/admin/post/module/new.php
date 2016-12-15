<?php

$headTitle = trans("Nowy moduł w poście");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$parent_id = intval(array_shift($_SEGMENTS));
$post = GC\Model\Post::selectWithFrameByPrimaryId($parent_id);
$frame_id = $post['frame_id'];

$headTitle .= makeLink("/admin/page/list", $post['name']);

require_once ACTIONS_PATH.'/admin/parts/module/new.html.php'; ?>
