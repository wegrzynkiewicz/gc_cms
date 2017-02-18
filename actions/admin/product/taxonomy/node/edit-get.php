<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/node/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz węzeł o $frame_id
$node = GC\Model\Product\Tree::select()
    ->source('::nodes')
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $node;

require ACTIONS_PATH.'/admin/product/taxonomy/node/form.html.php';
