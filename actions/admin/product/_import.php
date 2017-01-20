<?php

$headTitle = $trans('Produkty');
GC\Url::extendMask('/product%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'fa-shopping-basket',
]);
