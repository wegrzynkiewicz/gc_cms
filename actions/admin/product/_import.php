<?php

$headTitle = $trans('Produkty');
$uri->extendMask('/product%s');
print_r($uri);
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'shopping-basket',
]);
