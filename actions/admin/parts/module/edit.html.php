<?php

$module_id = intval(array_shift($_SEGMENTS));

$module = GC\Model\FrameModule::selectByPrimaryId($module_id);
$moduleType = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);
if (!is_array($settings)) {
    $settings = [];
}

require_once ACTIONS_PATH."/admin/parts/module/types/$moduleType/edit.html.php";
