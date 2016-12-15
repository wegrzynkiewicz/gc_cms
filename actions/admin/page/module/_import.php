<?php

$frame = "page";

$parent_id = intval(array_pop($_SEGMENTS));
$page = GC\Model\Page::selectWithFrameByPrimaryId($parent_id);
$frame_id = $page['frame_id'];

$headTitle = trans('Moduły na stronie "%s"', [$page['name']]);
$breadcrumbs->push("/admin/page/module/list/$parent_id", $headTitle);
