<?php

$action = array_shift($_SEGMENTS);

$item_id = intval(array_pop($_SEGMENTS));
$item = GC\Model\ModuleItem::selectWithFrameByPrimaryId($item_id);
$frame_id = $item['frame_id'];

$headTitle = trans('Moduły "%s"', [$item['name']]);
$breadcrumbs->push($surl("/item/list/$item_id"), $headTitle);

require_once ACTIONS_PATH."/admin/parts/module/$action.html.php";
