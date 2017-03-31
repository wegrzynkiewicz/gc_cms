<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/_import.php";

$navigation_id = intval(array_shift($_PARAMETERS));

// pobierz okienko po kluczu głównym
$navigation = GC\Model\Navigation::select()
    ->equals('navigation_id', $navigation_id)
    ->fetch();

$headTitle = trans('Edycja nawigacji: %s', [$navigation['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $navigation;

require ROUTES_PATH."/admin/navigation/_form.html.php";
