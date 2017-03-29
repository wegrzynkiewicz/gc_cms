<?php

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module::fetchByPrimaryId($module_id);

$type = $module['type'];

require ROUTES_PATH."/admin/module/type/{$type}/post-edit.html.php";
