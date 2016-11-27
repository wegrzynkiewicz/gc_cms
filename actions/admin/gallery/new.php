<?php

$headTitle = trans("Dodawanie nowej galerii");

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    GalleryModel::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['staff']['editorLang'],
    ]);

    redirect('/admin/gallery/list');
}

require_once ACTIONS_PATH.'/admin/gallery/form.html.php';
