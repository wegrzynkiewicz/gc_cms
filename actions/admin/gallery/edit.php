<?php

$headTitle = trans("Edytowanie galerii");

Staff::createFromSession()->redirectIfUnauthorized();

$id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    GalleryModel::update($id, [
        'name' => $_POST['name'],
        'lang' => $_SESSION['staff']['editorLang'],
    ]);
    redirect('/admin/gallery/list');
}

$row = GalleryModel::selectByPrimaryId($id);
if (!$row) {
    redirect('/admin/gallery/list');
}

$headTitle .= makeLink("/admin/gallery/list", $row['name']);
$_POST = $row;

require_once ACTIONS_PATH.'/admin/gallery/form.html.php';
