<?php

$headTitle = $trans('Dodawanie nowego pola');
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$refreshUrl = GC\Url::mask('/types');

require ACTIONS_PATH.'/admin/form/field/form.html.php';
