<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/node/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz węzeł o $frame_id
$node = GC\Model\Post\Tree::select()
    ->source('::nodes')
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = trans('Edycja węzła: %s', [$node['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $node;

require ROUTES_PATH.'/admin/post/taxonomy/node/_form.html.php';
