<?php

$headTitle = trans('Produkty');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/list/{$type}"),
    'name' => $headTitle,
    'icon' => 'shopping-basket',
]);
