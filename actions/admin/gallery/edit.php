<?php

$headTitle = trans("Edytowanie galerii");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));

if (isPost()) {
    GC\Model\Gallery::updateByPrimaryId($gallery_id, [
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
    ]);
    GC\Response::redirect('/admin/gallery/list');
}

$gallery = GC\Model\Gallery::selectByPrimaryId($gallery_id);
if (!$gallery) {
    GC\Response::redirect('/admin/gallery/list');
}

$headTitle .= makeLink("/admin/gallery/list", $gallery['name']);
$_POST = $gallery;

require ACTIONS_PATH.'/admin/gallery/form.html.php';
