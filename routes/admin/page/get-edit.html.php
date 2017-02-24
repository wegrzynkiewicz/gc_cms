<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$headTitle = trans('Edycja strony: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $frame;

require ROUTES_PATH.'/admin/page/form.html.php';
