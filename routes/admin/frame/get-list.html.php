<?php

require ROUTES_PATH.'/admin/_import.php';

$type = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_get-list.html.php";
