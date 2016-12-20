<?php

$headTitle = trans('Dodawanie nowego wpisu');
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    $frame_id = GC\Model\Frame::insert([
        'name' => $_POST['name'],
        'type' => 'post',
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    $relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

    GC\Model\Post::insertWithRelations([
        'frame_id' => $frame_id,
    ], $relations);

    setNotice(trans('Nowy wpis "%s" została utworzony.', [$_POST['name']]));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$checkedValues = [];

require_once ACTIONS_PATH.'/admin/post/form.html.php';
