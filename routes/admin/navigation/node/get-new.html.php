<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/navigation/_import.php';

$navigation_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH.'/admin/navigation/node/_import.php';

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$node_id = 0;

require ROUTES_PATH.'/admin/navigation/node/_form.html.php';
