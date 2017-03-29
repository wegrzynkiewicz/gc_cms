<?php

$form_id = intval(array_shift($_PARAMETERS));
$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);
$headTitle = trans('Nadesłane dla: %s', [$form['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/form/{$form_id}/received/list"),
    'name' => $headTitle,
    'icon' => 'envelope-open-o',
]);
