<?php

$headTitle = trans('Nawigacje');
$uri->extendMask('/nav%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'sitemap',
]);
