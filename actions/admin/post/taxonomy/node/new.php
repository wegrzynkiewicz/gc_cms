<?php

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push($request, $headTitle);

$menu_id = 0;

if(isPost()) {

    $frame_id = GC\Model\Frame::insert([
        'name' => $_POST['name'],
        'type' => 'post-node',
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    GC\Model\PostNode::insertWithTaxonomyId([
        'frame_id' => $frame_id,
    ], $tax_id);

    setNotice(trans('Nowy węzeł "%s" dostał dodany do "%s".', [$_POST['name'], $taxonomy['name']]));

    GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
}

require ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
