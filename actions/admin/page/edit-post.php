<?php

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);

GC\Model\Frame::updateByFrameId($page['frame_id'], [
    'name' => $_POST['name'],
    'keywords' => $_POST['keywords'],
    'description' => $_POST['description'],
    'image' => $_POST['image'],
]);

setNotice(trans('Strona "%s" została zaktualizowana.', [$_POST['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
