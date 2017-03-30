<?php

require ROUTES_PATH."/admin/_import.php";

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module::select()
    ->source('::grid')
    ->equals('module_id', $module_id)
    ->fetch();

$frame_id = $module['frame_id'];

require ROUTES_PATH."/admin/module/parts/_breadcrumbs-loop.php";

$moduleType = $module['type'];
$moduleTheme = $_POST['theme'] ?? $module['theme'];

require ROUTES_PATH."/admin/module/types/{$moduleType}/_post-edit.html.php";
require ROUTES_PATH."/admin/module/types/{$moduleType}/themes/{$moduleTheme}/_post-edit.html.php";

redirect($breadcrumbs->getLast()['uri']);
