<?php

$form_id = intval(array_shift($_PARAMETERS));

# pobierz formularz po kluczu głównym
$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);

$headTitle = trans('Pola formularza: %s', [$form['name']]);
$uri->extendMask("/{$form_id}/field%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'envelope-open-o',
]);
