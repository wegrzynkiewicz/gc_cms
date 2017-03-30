<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/form/_import.php';
require ROUTES_PATH.'/admin/form/field/_import.php';

$headTitle = trans('Dodawanie nowego pola');
$breadcrumbs->push([
    'name' => $headTitle,
]);

require ROUTES_PATH.'/admin/form/field/_form.html.php';
