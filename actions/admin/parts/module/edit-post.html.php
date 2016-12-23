<?php

$module = GC\Model\Module::selectByPrimaryId($module_id);
$moduleType = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);
if (!is_array($settings)) {
    $settings = [];
}

require ACTIONS_PATH."/admin/parts/module/type/$moduleType/edit-post.html.php";
