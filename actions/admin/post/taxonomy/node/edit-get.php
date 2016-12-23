<?php

$node = GC\Model\PostNode::selectWithFrameByPrimaryId($node_id);
$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push($request->path, $headTitle);

$_POST = $node;

require ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
