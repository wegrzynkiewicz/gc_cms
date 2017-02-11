<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/node/_import.php';

$node_id = intval(array_shift($_PARAMETERS));

# pobierz węzeł razem z ramką o $node_id
$node = GC\Model\Product\Node::select()
    ->source('::frame')
    ->equals('node_id', $node_id)
    ->fetch();

$headTitle = $trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

$_POST = $node;

require ACTIONS_PATH.'/admin/product/taxonomy/node/form.html.php';
