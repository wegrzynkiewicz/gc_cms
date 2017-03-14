<?php

require ROUTES_PATH.'/admin/_import.php';

$type = array_shift($_SEGMENTS);

# pobierz liczbę odpowiednich rusztowań
$count = GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', $type)
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count'];
    
require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_get-list.html.php";
