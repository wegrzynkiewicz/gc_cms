<?php

$nav_id = intval(array_shift($_PARAMETERS));

# pobranie nawigacji o zadanym kluczu
$nav = GC\Model\Menu\Taxonomy::select()
    ->fields(['name'])
    ->equals('nav_id', $nav_id)
    ->fetch();

$headTitle = $trans('%s - węzły', [$nav['name']]);
GC\Url::extendMask("/{$nav_id}/menu%s");
$breadcrumbs->push([
    'url' => GC\Url::mask('/tree'),
    'name' => $headTitle,
]);
