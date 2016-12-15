<?php

$title = "Edycja strony %s";

$page_id = intval(array_shift($_SEGMENTS));
$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);

if (wasSentPost()) {

    GC\Model\Frame::updateByFrameId($page['frame_id'], [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$headTitle = trans($title, [$page['name']]);
$breadcrumbs->push($request, $headTitle);

$_POST = $page;

require_once ACTIONS_PATH.'/admin/page/form.html.php';
