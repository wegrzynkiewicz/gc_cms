<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/popup/_import.php';

$popup_id = intval(array_shift($_PARAMETERS));

# pobierz okienko po kluczu głównym
$popup = GC\Model\PopUp\PopUp::select()
    ->equals('popup_id', $popup_id)
    ->fetch();

$headTitle = trans('Edycja okienka: %s', [$popup['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $popup;
$popupType = $popup['type'];

require ROUTES_PATH.'/admin/popup/form.html.php';
