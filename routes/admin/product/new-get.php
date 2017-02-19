<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/product/_import.php';

$headTitle = trans('Dodawanie nowego produktu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

# wartości do jakich węzłów należy produkt
$checkedValues = [];

require ROUTES_PATH.'/admin/product/form.html.php';
