<?php

$headTitle = trans("Dodawanie nowej galerii");

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    Gallery::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['staff']['langEditor'],
    ]);

    redirect('/admin/gallery/list');
}

require_once ACTIONS_PATH.'/admin/gallery/form.html.php';
