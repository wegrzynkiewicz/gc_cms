<?php

$headTitle = trans("Edytowanie strony");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$page_id = intval(array_shift($_SEGMENTS));
$page = Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

if (wasSentPost()) {

    Frame::updateByFrameId($frame_id, [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    redirect('/admin/page/list');
}

if (!$page) {
    redirect('/admin/page/list');
}

$headTitle .= makeLink("/admin/page/list", $page['name']);

$_POST = $page;

require_once ACTIONS_PATH.'/admin/page/form.html.php';
