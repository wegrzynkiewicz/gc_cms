<?php

$headTitle = $trans('Dodawanie nowego pracownika');
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

$groups = [];

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/staff/form.html.php'; ?>
