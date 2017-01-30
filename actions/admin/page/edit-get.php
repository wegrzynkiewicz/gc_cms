<?php

$page_id = intval(array_shift($_PARAMETERS));
$page = GC\Model\Page::select()
    ->source('::frame')
    ->equals('page_id', $page_id)
    ->fetch();
$headTitle = $trans('Edycja strony %s', [$page['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);
$_POST = $page;

require ACTIONS_PATH.'/admin/page/form.html.php';
