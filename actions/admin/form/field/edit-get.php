<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

$field_id = intval(array_shift($_PARAMETERS));

# pobierz pole po kluczu głównym
$field = GC\Model\Form\Field::fetchByPrimaryId($field_id);

$headTitle = $trans('Edycja pola "%s"', [$field['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

$_POST = $field;
$type = $field['type'];
$fieldType = render(ACTIONS_PATH."/admin/form/field/types/{$type}-get.php", $field);

require ACTIONS_PATH.'/admin/form/field/form.html.php';
