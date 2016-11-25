<?php

$headTitle = trans("Dodawanie nowej galerii");

checkPermissions();

if (wasSentPost()) {
    GalleryModel::insert([
        'name' => $_POST['name'],
        'lang' => $config['lang']['editor'],
    ]);

    redirect('/admin/gallery/list');
}

require_once ACTIONS_PATH.'/admin/gallery/form.html.php';
