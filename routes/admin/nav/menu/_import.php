<?php

$nav_id = intval(array_shift($_PARAMETERS));

# pobranie nawigacji o zadanym kluczu
$nav = GC\Model\Menu\Taxonomy::select()
    ->equals('nav_id', $nav_id)
    ->fetch();

$headTitle = trans('%s - węzły', [$nav['name']]);
$uri->extendMask("/{$nav_id}/menu%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/tree'),
    'name' => $headTitle,
]);