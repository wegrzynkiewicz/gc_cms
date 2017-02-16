<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

$headTitle = $trans('Dodawanie nowego pola');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/form/field/form.html.php';
