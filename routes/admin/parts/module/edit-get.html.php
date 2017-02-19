<?php

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);

$type = $module['type'];
$_POST = $module;

$uri->extendMask("/{$module_id}%s");

require ROUTES_PATH."/admin/parts/module/type/{$type}/edit-{$request->method}.html.php";
