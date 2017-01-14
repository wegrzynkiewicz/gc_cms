<?php

$node = GC\Model\Post\Node::selectWithFrameByPrimaryId($node_id);
$headTitle = $trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$_POST = $node;

require ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
