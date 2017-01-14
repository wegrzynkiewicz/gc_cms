<?php

$headTitle = $trans("Dodawanie nowego pracownika");
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$groups = [];

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
require ACTIONS_PATH.'/admin/parts/page-header.html.php';
require ACTIONS_PATH.'/admin/staff/form.html.php'; ?>
