<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/staff/_import.php';

$headTitle = trans('Dodawanie nowego pracownika');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$groups = [];

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/staff/_form.html.php'; ?>
