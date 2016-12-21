<?php

$module = GC\Model\Module::selectByPrimaryId($module_id);
$moduleType = $module['type'];

require ACTIONS_PATH."/admin/parts/module/types/{$moduleType}/_import.php";

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\ModuleItem::selectWithFrameByPrimaryId($item_id);
$frame_id = $item['frame_id'];

$surl = function($path) use ($surl, $module_id, $item_id) {
    return $surl("/{$module_id}/item/{$item_id}/module{$path}");
};

require ACTIONS_PATH."/admin/parts/module/types/{$moduleType}/item.html.php";

$moduleName = intval(array_shift($_SEGMENTS));
if ($moduleName == 'module') {
    if (isset($_SEGMENTS[0]) and intval($_SEGMENTS[0])) {
        $module_id = intval(array_shift($_SEGMENTS));
    }
    $action = array_shift($_SEGMENTS);
    require ACTIONS_PATH."/admin/parts/module/$action.html.php";
}
