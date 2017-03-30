<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$frameType = $frame['type'];

require ROUTES_PATH."/admin/frame/_breadcrumbs-list.php";
require ROUTES_PATH."/admin/frame/type/{$frameType}/_get-tree.html.php";
