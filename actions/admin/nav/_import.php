<?php

$headTitle = $trans('Nawigacje');
$uri->extendMask('/nav%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'sitemap',
]);
