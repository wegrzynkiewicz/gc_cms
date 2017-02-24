<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/node/_import.php';

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'name' => $headTitle,
]);

require ROUTES_PATH.'/admin/post/taxonomy/node/form.html.php';
