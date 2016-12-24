<?php

$module = GC\Model\Module::selectByPrimaryId($module_id);
$type = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);
if (!is_array($settings)) {
    $settings = [];
}

GC\Url::extendMask("/{$module_id}%s");

require ACTIONS_PATH."/admin/parts/module/type/{$type}/_import.php";

require ACTIONS_PATH."/admin/parts/module/type/{$type}/edit-{$request->method}.html.php";
