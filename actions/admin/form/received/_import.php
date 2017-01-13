<?php

$form = GC\Model\Form\Form::fetchByPrimaryId($form_id);
$headTitle = $trans('Nadesłane dla "%s"', [$form['name']]);
GC\Url::extendMask("/{$form_id}/received%s");
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-envelope-open-o');
$sent_id = shiftSegmentAsInteger();
