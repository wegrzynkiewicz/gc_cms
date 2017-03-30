<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/form/_import.php';
require ROUTES_PATH.'/admin/form/field/_import.php';

$field_id = intval(array_shift($_PARAMETERS));

# pobierz pole po kluczu głównym
$field = GC\Model\Form\Field::fetchByPrimaryId($field_id);

$headTitle = trans('Edycja pola: %s', [$field['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $field;
$type = $field['type'];
$fieldType = render(ROUTES_PATH."/admin/form/field/type/{$type}-get.php", $field);

require ROUTES_PATH.'/admin/form/field/_form.html.php';
