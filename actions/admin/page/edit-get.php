<?php

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
$headTitle = $trans("Edycja strony %s", [$page['name']]);
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);
$_POST = $page;

require ACTIONS_PATH.'/admin/page/form.html.php';
