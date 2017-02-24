<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/node/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz węzeł po kluczu głównym
$node = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = trans('Moduły w węźle: %s', [$node['name']]);
$uri->extendMask("/{$frame_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);

$frame = $node;
$action = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/module/{$action}-{$request->method}.html.php";
