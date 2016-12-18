<?php

$form_id = intval(array_pop($_SEGMENTS));
$form = GC\Model\Form::selectByPrimaryId($form_id);

$headTitle = trans('Nadesłane dla "%s"', [$form['name']]);
$breadcrumbs->push("/admin/form/received/list/$form_id", $headTitle, 'fa-envelope-open-o');
