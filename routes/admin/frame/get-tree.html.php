<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$type = $frame['type'];

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_get-tree.html.php";
