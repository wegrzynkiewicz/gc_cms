<?php

$post_id = intval(array_shift($_SEGMENTS));
$node = GC\Model\PostNode::selectWithFrameByPrimaryId($post_id);
$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push($request, $headTitle);

if(isPost($_POST)) {

    GC\Model\Frame::updateByFrameId($node['frame_id'], [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    setNotice(trans('Węzeł "%s" został zaktualizowany.', [$node['name']]));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $node;

require_once ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
