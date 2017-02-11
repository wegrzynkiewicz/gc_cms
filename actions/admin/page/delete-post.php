<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$page_id = intval(post('page_id'));
$page = GC\Model\Page::select()
    ->source('::frame')
    ->equals('page_id', $page_id)
    ->fetch();
GC\Model\Page::deleteFrameByPrimaryId($page_id);

setNotice($trans('Strona "%s" została usunięta.', [$page['name']]));
redirect($breadcrumbs->getLast('uri'));
