<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(post('frame_id'));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->fields(['name', 'type'])
    ->equals('frame_id', $frame_id)
    ->fetch();

# usuń rusztowanie i wszystkie jej moduły
GC\Model\Frame::deleteByFrameId($frame_id);

$frameType = $frame['type'];
require ROUTES_PATH."/admin/frame/_breadcrumbs-list.php";
require ROUTES_PATH."/admin/frame/type/{$frameType}/_post-delete.html.php";

redirect($breadcrumbs->getLast('uri'));
