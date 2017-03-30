<?php

require ROUTES_PATH."/admin/_import.php";

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module::fetchByPrimaryId($module_id);

$moduleType = $module['type'];
$moduleTheme = GC\Validation\Required::enum(
    'theme',
    array_keys($config['module']['types'][$moduleType]['themes'])
);

$meta = GC\Model\Module\Meta::fetchMeta($module_id);
$_POST = array_merge($module, $meta);

require ROUTES_PATH."/admin/module/types/{$moduleType}/themes/{$moduleTheme}/_get-edit.html.php";
