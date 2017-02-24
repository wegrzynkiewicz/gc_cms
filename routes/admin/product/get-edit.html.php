<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/product/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = trans('Edytowanie produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $frame;

# pobranie kluczy node_id, do których przynależy produkt
$checkedValues = array_keys(GC\Model\Product\Membership::select()
    ->fields(['node_id'])
    ->equals('frame_id', $frame_id)
    ->fetchByMap('node_id', 'node_id'));

require ROUTES_PATH.'/admin/product/_form.html.php';
