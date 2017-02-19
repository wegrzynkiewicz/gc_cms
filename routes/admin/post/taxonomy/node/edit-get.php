<?php

$node = GC\Model\Post\Node::selectWithFrameByPrimaryId($node_id);
$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $node;

require ROUTES_PATH.'/admin/post/taxonomy/node/form.html.php';
