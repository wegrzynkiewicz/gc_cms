<?php

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

$headTitle = $trans('Moduły na stronie "%s"', [$page['name']]);
$uri->extendMask("/{$page_id}/module%s");
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
]);

$getPreviewUrl = function () use ($page_id) {
    return $uri->make("/page/{$page_id}");
};

require ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
