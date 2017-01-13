<?php

$headTitle = $trans('Dodawanie nowego pola');
$breadcrumbs->push($request->path, $headTitle);

$refreshUrl = GC\Url::mask('/types');

require ACTIONS_PATH.'/admin/form/field/form.html.php';
