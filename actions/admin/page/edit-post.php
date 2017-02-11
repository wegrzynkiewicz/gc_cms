<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$page = GC\Model\Page::select()
    ->source('::frame')
    ->equals('page_id', $page_id)
    ->fetch();

GC\Model\Module\Frame::updateByFrameId($page['frame_id'], [
    'name' => post('name'),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload($_POST['image']),
]);

setNotice($trans('Strona "%s" została zaktualizowana.', [$_POST['name']]));

redirect($breadcrumbs->getLast('uri'));
