<?php

$form_id = intval(array_shift($_PARAMETERS));
$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);
$headTitle = $trans('Pola formularza "%s"', [$form['name']]);
GC\Url::extendMask("/{$form_id}/field%s");
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'fa-envelope-open-o',
]);
$field_id = intval(array_shift($_PARAMETERS));
