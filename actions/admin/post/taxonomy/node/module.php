<?php

$node = GC\Model\Post\Node::selectWithFrameByPrimaryId($node_id);
$frame_id = $node['frame_id'];

$headTitle = $trans('Moduły w węźle "%s"', [$node['name']]);
$uri->extendMask("/{$node_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);

$getPreviewUrl = function () use ($node_id) {
    return $uri->make("/post/node/{$node_id}");
};

require ACTIONS_PATH."/admin/parts/module/_import.php";

$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
