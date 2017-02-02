<?php

$headTitle = $trans('Produkty');
$uri->extendMask('/product%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'shopping-basket',
]);
