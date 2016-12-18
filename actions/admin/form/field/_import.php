<?php

$form_id = intval(array_pop($_SEGMENTS));
$form = GC\Model\Form::selectByPrimaryId($form_id);

$headTitle = trans('Pola formularza "%s"', [$form['name']]);
$breadcrumbs->push("/admin/form/field/list/$form_id", $headTitle);
