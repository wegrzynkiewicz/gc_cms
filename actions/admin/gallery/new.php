<?php

$headTitle = trans("Dodawanie nowej galerii");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (isPost()) {
    GC\Model\Gallery::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
    ]);

    GC\Response::redirect('/admin/gallery/list');
}

require ACTIONS_PATH.'/admin/gallery/form.html.php';
