<?php

require ROUTES_PATH.'/admin/_import.php';

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module::fetchByPrimaryId($module_id);

$moduleType = $module['type'];

require ROUTES_PATH."/admin/module/type/{$moduleType}/post-edit.html.php";
