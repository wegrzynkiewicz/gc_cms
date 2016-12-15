<?php

$headTitle = trans('Dodawanie nowej strony');
$breadcrumbs->push($request, $headTitle);

if (wasSentPost()) {

    $frame_id = GC\Model\Frame::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    GC\Model\Page::insert([
        'frame_id' => $frame_id,
    ]);

    redirect($breadcrumbs->getBeforeLastUrl());
}

require_once ACTIONS_PATH.'/admin/page/form.html.php';
