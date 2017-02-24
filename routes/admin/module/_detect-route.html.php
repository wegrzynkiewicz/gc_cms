<?php

$action = array_shift($_SEGMENTS);
require ROUTES_PATH."/admin/module/_{$request->method}-{$action}.html.php";
