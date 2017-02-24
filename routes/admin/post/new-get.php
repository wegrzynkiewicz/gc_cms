<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';

$headTitle = trans('Dodawanie nowego wpisu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

# wartości do jakich węzłów należy produkt
$checkedValues = [];

require ROUTES_PATH.'/admin/post/form.html.php';
