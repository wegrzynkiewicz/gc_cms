<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/navigation/_import.php';

$headTitle = trans('Dodawanie nowej nawigacji');
$breadcrumbs->push([
    'name' => $headTitle,
]);

require ROUTES_PATH.'/admin/navigation/_form.html.php';
