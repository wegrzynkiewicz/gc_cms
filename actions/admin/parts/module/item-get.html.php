<?php

$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);
$moduleType = $module['type'];

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\Module\Item::selectWithFrameByPrimaryId($item_id);
$frame_id = $item['frame_id'];

GC\Url::extendMask("/{$module_id}%s");
require ACTIONS_PATH."/admin/parts/module/type/{$moduleType}/_import.php";
GC\Url::extendMask("/item/{$item_id}/module%s");
require ACTIONS_PATH."/admin/parts/module/type/{$moduleType}/item.html.php";

$moduleName = intval(array_shift($_SEGMENTS));
if ($moduleName == 'module') {
    if (isset($_SEGMENTS[0]) and intval($_SEGMENTS[0])) {
        $module_id = intval(array_shift($_SEGMENTS));
    }
    $action = array_shift($_SEGMENTS);
    require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
}