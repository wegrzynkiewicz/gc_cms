<?php

$field = GC\Model\FormField::selectByPrimaryId($field_id);

$headTitle = trans('Edycja pola "%s"', [$field['name']]);
$breadcrumbs->push($request->path, $headTitle);

$refreshUrl = GC\Url::mask("/{$field_id}/types");
$_POST = $field;

require ACTIONS_PATH.'/admin/form/field/form.html.php';