<?php

$form = GC\Model\Form::selectByPrimaryId($form_id);
$headTitle = trans('Pola formularza "%s"', [$form['name']]);
GC\Url::extendMask("/{$form_id}/field%s");
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-envelope-open-o');
$field_id = shiftSegmentAsInteger();
