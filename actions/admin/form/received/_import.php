<?php

if (intval($_SEGMENTS[0])) {
    $sent_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl, $form_id) {
    return $surl("/{$form_id}/received{$path}");
};

$form = GC\Model\Form::selectByPrimaryId($form_id);

$headTitle = trans('Nadesłane dla "%s"', [$form['name']]);
$breadcrumbs->push($surl("/list"), $headTitle, 'fa-envelope-open-o');
