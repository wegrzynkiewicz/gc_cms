<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/staff/_import.php';

$headTitle = trans('Dodawanie nowego pracownika');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$groups = [];

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/staff/form.html.php'; ?>
