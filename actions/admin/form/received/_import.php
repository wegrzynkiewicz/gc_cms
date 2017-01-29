<?php

$form_id = intval(array_shift($_PARAMETERS));
$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);
$headTitle = $trans('Nadesłane dla "%s"', [$form['name']]);
$uri->extendMask("/{$form_id}/received%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'envelope-open-o',
]);
