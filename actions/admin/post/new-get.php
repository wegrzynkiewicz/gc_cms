<?php

$headTitle = $trans('Dodawanie nowego wpisu');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

$checkedValues = [];

require ACTIONS_PATH.'/admin/post/form.html.php';
