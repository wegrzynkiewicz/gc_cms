<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$page = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = $trans('Moduły na stronie "%s"', [$page['name']]);
$uri->extendMask("/{$frame_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);

$frame = $page;
$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
