<?php

$headTitle = trans('Dodawanie nowego wpisu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$checkedValues = [];

require ROUTES_PATH.'/admin/post/form.html.php';
