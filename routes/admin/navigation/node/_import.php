<?php

# pobranie nawigacji o zadanym kluczu głównym
$navigation = GC\Model\Navigation::select()
    ->equals('navigation_id', $navigation_id)
    ->fetch();

$headTitle = trans('Struktura nawigacji: %s', [$navigation['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/navigation/{$navigation_id}/node/tree"),
    'name' => $headTitle,
]);
