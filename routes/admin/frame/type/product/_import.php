<?php

$headTitle = trans('Produkty');
$uri->extendMask('/frame%s');
$breadcrumbs->push([
    'uri' => $uri->mask("/list/{$type}"),
    'name' => $headTitle,
    'icon' => 'shopping-basket',
]);
