<?php

$field_id = intval(array_shift($_PARAMETERS));
$field = GC\Model\Form\Field::fetchByPrimaryId($field_id);

$headTitle = $trans('Edycja pola "%s"', [$field['name']]);
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

$refreshUrl = GC\Url::mask("/{$field_id}/types");
$_POST = $field;

require ACTIONS_PATH.'/admin/form/field/form.html.php';
