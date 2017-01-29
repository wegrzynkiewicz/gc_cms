<?php

$page_id = intval(array_shift($_PARAMETERS));
$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
$headTitle = $trans('Edycja strony %s', [$page['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);
$_POST = $page;

require ACTIONS_PATH.'/admin/page/form.html.php';
