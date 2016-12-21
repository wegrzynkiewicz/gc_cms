<?php

require_once ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);
$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

$getPreviewUrl = function() use ($page_id) {
    return url("/page/$page_id");
};

$surl = function($path) use ($surl, $page_id) {
    return $surl("/{$page_id}/module{$path}");
};

$headTitle = trans('Moduły na stronie "%s"', [$page['name']]);
$breadcrumbs->push($surl("/list"), $headTitle);

//$path =  ACTIONS_PATH."/admin/parts/module";

require_once ACTIONS_PATH."/admin/parts/module/$action.html.php";
