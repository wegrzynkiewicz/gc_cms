<?php

$headTitle = $trans('Produkty');
$uri->extendMask('/product%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'shopping-basket',
]);
