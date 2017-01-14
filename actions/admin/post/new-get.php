<?php

$headTitle = $trans('Dodawanie nowego wpisu');
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$checkedValues = [];

require ACTIONS_PATH.'/admin/post/form.html.php';
