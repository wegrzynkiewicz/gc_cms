<?php

$headTitle = trans("Edytowanie galerii");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    Gallery::updateByPrimaryId($gallery_id, [
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
    ]);
    redirect('/admin/gallery/list');
}

$gallery = Gallery::selectByPrimaryId($gallery_id);
if (!$gallery) {
    redirect('/admin/gallery/list');
}

$headTitle .= makeLink("/admin/gallery/list", $gallery['name']);
$_POST = $gallery;

require_once ACTIONS_PATH.'/admin/gallery/form.html.php';
