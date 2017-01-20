<?php

$module_id = intval(array_shift($_PARAMETERS));

$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);
$type = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);
if (!is_array($settings)) {
    $settings = [];
}

GC\Url::extendMask("/{$module_id}%s");

require ACTIONS_PATH."/admin/parts/module/type/{$type}/_import.php";

require ACTIONS_PATH."/admin/parts/module/type/{$type}/edit-{$request->method}.html.php";
