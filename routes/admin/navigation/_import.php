<?php

$headTitle = trans('Nawigacje');
$uri->extendMask('/navigation%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'sitemap',
]);
