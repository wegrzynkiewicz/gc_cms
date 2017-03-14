<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = 0;
$type = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_get-new.html.php";
