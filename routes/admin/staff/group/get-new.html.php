<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/staff/_import.php';
require ROUTES_PATH.'/admin/staff/group/_import.php';

$headTitle = trans('Dodawanie nowej grupy pracowników');
$breadcrumbs->push([
    'name' => $headTitle,
]);
$permissions = [];

require ROUTES_PATH.'/admin/staff/group/_form.html.php';
