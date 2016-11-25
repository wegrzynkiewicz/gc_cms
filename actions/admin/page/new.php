<?php

$headTitle = trans("Dodawanie nowej strony");

Staff::createFromSession()->redirectIfUnauthorized();

if (wasSentPost()) {

    $frame_id = FrameModel::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['staff']['editorLang'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    PageModel::insert([
        'frame_id' => $frame_id,
    ]);

    redirect('/admin/page/list');
}

require_once ACTIONS_PATH.'/admin/page/form.html.php';
