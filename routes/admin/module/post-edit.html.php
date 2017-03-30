<?php

require ROUTES_PATH.'/admin/_import.php';

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module::select()
    ->source('::grid')
    ->equals('module_id', $module_id)
    ->fetch();

$frame_id = $module['frame_id'];

require ROUTES_PATH."/admin/module/_breadcrumbs-loop.php";

$moduleType = $module['type'];

require ROUTES_PATH."/admin/module/type/{$moduleType}/_post-edit.html.php";
