<?php

$headTitle = trans('Dodawanie nowej strony');
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    $frame_id = GC\Model\Frame::insert([
        'name' => $_POST['name'],
        'type' => 'page',
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    GC\Model\Page::insert([
        'frame_id' => $frame_id,
    ]);

    setNotice(trans('Nowa strona "%s" została utworzona.', [$_POST['name']]));

    redirect($breadcrumbs->getBeforeLastUrl());
}

require ACTIONS_PATH.'/admin/page/form.html.php';
