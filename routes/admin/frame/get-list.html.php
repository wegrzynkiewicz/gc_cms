<?php

require ROUTES_PATH.'/admin/_import.php';

$frameType = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/frame/_breadcrumbs-list.php";
require ROUTES_PATH."/admin/frame/type/{$frameType}/_get-list.html.php";
