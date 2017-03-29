<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$type = $frame['type'];
require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";

require ROUTES_PATH."/admin/frame/type/{$type}/_module.html.php";

$action = array_shift($_SEGMENTS);
require ROUTES_PATH."/admin/module/_{$request->method}-{$action}.html.php";
