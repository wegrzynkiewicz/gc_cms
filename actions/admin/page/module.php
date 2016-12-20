<?php

$action = array_shift($_SEGMENTS);
$page_id = intval(array_pop($_SEGMENTS));

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

$getPreviewUrl = function() use ($page_id) {
    return url("/page/$page_id");
};

$getModuleUrl = function($path) use ($page_id) {
    return url("/admin/page/module$path/$page_id");
};

$headTitle = trans('Moduły na stronie "%s"', [$page['name']]);
$breadcrumbs->push($getModuleUrl("/list"), $headTitle);

require_once ACTIONS_PATH."/admin/parts/module/$action.html.php";
