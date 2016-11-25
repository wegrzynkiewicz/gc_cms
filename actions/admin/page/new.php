<?php

$headTitle = trans("Dodawanie nowej strony");

checkPermissions();

if (wasSentPost()) {

    $frame_id = FrameModel::insert([
        'name' => $_POST['name'],
        'lang' => $config['lang']['editor'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    PageModel::insert([
        'frame_id' => $frame_id,
    ]);

    redirect('/admin/page/list');
}

require_once ACTIONS_PATH.'/admin/page/form.html.php';
