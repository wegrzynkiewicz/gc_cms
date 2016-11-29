<?php

$headTitle = trans("Moduły na stronie");

$staff->redirectIfUnauthorized();

$parent_id = intval(array_shift($_SEGMENTS));
$page = Page::selectWithFrameByPrimaryId($parent_id);
$frame_id = $page['frame_id'];

$headTitle .= makeLink("/admin/page/list", $page['name']);

require_once ACTIONS_PATH.'/admin/module/list.html.php'; ?>
