<?php

$form_id = intval(array_shift($_PARAMETERS));

# pobierz formularz po kluczu głównym
$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);

$headTitle = trans('Pola formularza: %s', [$form['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/form/{$form_id}/field/list"),
    'name' => $headTitle,
    'icon' => 'envelope-open-o',
]);
