<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/nav/_import.php';
require ROUTES_PATH.'/admin/nav/menu/_import.php';

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$refreshUrl = $uri->mask("/edit-views");

require ROUTES_PATH.'/admin/nav/menu/_form.html.php';
