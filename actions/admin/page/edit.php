<?php

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);

$headTitle = trans("Edycja strony %s", [$page['name']]);
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    GC\Model\Frame::updateByFrameId($page['frame_id'], [
        'name' => $_POST['name'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => $_POST['image'],
    ]);

    setNotice(trans('Strona "%s" została zaktualizowana.', [$page['name']]));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $page;

require_once ACTIONS_PATH.'/admin/page/form.html.php';
