<?php

$frame = "page";

$action = array_shift($_SEGMENTS);

$parent_id = intval(array_pop($_SEGMENTS));
$page = GC\Model\Page::selectWithFrameByPrimaryId($parent_id);
$frameData = $page;
$frame_id = $page['frame_id'];

$headTitle = trans('Moduły na stronie "%s"', [$page['name']]);
$breadcrumbs->push("/admin/page/module/list/$parent_id", $headTitle);

require_once ACTIONS_PATH."/admin/parts/module/$action.html.php";
