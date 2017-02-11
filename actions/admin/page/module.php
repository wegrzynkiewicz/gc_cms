<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$page = GC\Model\Page::select()
    ->source('::frame')
    ->equals('page_id', $page_id)
    ->fetch();

$frame_id = $page['frame_id'];

$headTitle = $trans('Moduły na stronie "%s"', [$page['name']]);
$uri->extendMask("/{$page_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);

$getPreviewUrl = function () use ($page_id) {
    return $uri->make("/page/{$page_id}");
};

require ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
