<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = trans('Moduły produktu "%s"', [$frame['name']]);
$uri->extendMask("/{$frame_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);

$action = array_shift($_SEGMENTS);

require ROUTES_PATH."/admin/module/{$action}-{$request->method}.html.php";
