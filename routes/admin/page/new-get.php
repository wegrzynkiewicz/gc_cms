<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/page/_import.php';

$headTitle = trans('Dodawanie nowej strony');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$frame_id = 0;

require ROUTES_PATH.'/admin/page/form.html.php';
