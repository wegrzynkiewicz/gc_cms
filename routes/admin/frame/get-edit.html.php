<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$frameType = $frame['type'];
$_POST = $frame;

require ROUTES_PATH."/admin/frame/_breadcrumbs-list.php";
require ROUTES_PATH."/admin/frame/type/{$frameType}/_get-edit.html.php";
