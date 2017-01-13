<?php

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

$headTitle = $trans('Moduły na stronie "%s"', [$page['name']]);
GC\Url::extendMask("/{$page_id}/module%s");
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle);

$getPreviewUrl = function () use ($page_id) {
    return GC\Url::make("/page/{$page_id}");
};

require ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
