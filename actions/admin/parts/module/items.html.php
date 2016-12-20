<?php

$action = array_shift($_SEGMENTS);
$module_id = intval(array_pop($_SEGMENTS));

$module = GC\Model\FrameModule::selectByPrimaryId($module_id);
$moduleType = $module['type'];

$getModuleItemUrl = function ($path) use ($module_id, $moduleType, $getModuleUrl) {
    return $getModuleUrl("/items/{$moduleType}{$path}/$module_id");
};

require_once ACTIONS_PATH."/admin/parts/module/types/$moduleType/items/$action.html.php";
