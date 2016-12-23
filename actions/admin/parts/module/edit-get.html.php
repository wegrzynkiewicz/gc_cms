<?php

$module = GC\Model\Module::selectByPrimaryId($module_id);
$moduleType = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);
if (!is_array($settings)) {
    $settings = [];
}

GC\Url::extendMask("/{$module_id}%s");

require ACTIONS_PATH."/admin/parts/module/type/{$moduleType}/edit-get.html.php";
