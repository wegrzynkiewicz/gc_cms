<?php

$action = array_shift($_SEGMENTS);
$node_id = intval(array_pop($_SEGMENTS));

$node = GC\Model\PostNode::selectWithFrameByPrimaryId($node_id);
$frame_id = $node['frame_id'];

$getPreviewUrl = function() use ($node_id) {
    return url("/post/node/$node_id");
};

$surl = function($path) use ($node_id) {
    return taxonomyNodeUrl("/module$path/$node_id");
};

$headTitle = trans('Moduły w węźle "%s"', [$node['name']]);
$breadcrumbs->push(GC\Url::make('/list'), $headTitle);

require ACTIONS_PATH."/admin/parts/module/$action.html.php";
