<?php

require ROUTES_PATH.'/admin/_import.php';

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module::select()
    ->source('::grid')
    ->equals('module_id', $module_id)
    ->fetch();

$frame_id = $module['frame_id'];

require ROUTES_PATH."/admin/module/_breadcrumbs-loop.php";
require ROUTES_PATH."/admin/module/_breadcrumbs-edit.php";

$moduleType = $module['type'];
$moduleTheme = $module['theme'];

$meta = GC\Model\Module\Meta::fetchMeta($module_id);
$_POST = array_merge($module, $meta);

$moduleThemeContent = render(ROUTES_PATH."/admin/module/types/{$moduleType}/themes/{$moduleTheme}/_get-edit.html.php");

require ROUTES_PATH."/admin/module/types/{$moduleType}/_get-edit.html.php";
