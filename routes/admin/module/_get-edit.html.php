<?php

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);

$type = $module['type'];
$theme = $module['theme'];

$meta = GC\Model\Module\Meta::fetchMeta($module_id);
$_POST = array_merge($module, $meta);

$uri->extendMask("/{$module_id}%s");

require ROUTES_PATH."/admin/module/type/{$type}/{$request->method}-edit.html.php";
