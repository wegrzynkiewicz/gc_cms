<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$frame_id = 0;
$frameType = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/frame/types/{$frameType}/breadcrumbs/_list.php";
require ROUTES_PATH."/admin/frame/types/{$frameType}/_get-new.html.php";
