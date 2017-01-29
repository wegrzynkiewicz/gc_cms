<?php

$field_id = 0;
$headTitle = $trans('Dodawanie nowego pola');
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

$refreshUrl = $uri->mask('/types');

require ACTIONS_PATH.'/admin/form/field/form.html.php';
