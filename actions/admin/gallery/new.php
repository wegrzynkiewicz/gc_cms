<?php

$headTitle = trans("Dodawanie nowej galerii");

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    GCC\Model\Gallery::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
    ]);

    redirect('/admin/gallery/list');
}

require_once ACTIONS_PATH.'/admin/gallery/form.html.php';
