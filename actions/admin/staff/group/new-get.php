<?php

$headTitle = $trans('Dodawanie nowej grupy pracowników');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);
$permissions = [];

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
