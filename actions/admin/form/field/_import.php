<?php

$field_id = intval(intval($_SEGMENTS[0]) ? array_shift($_SEGMENTS) : 0);

$surl = function($path) use ($surl, $form_id) {
    return $surl("/{$form_id}/field{$path}");
};

$form = GC\Model\Form::selectByPrimaryId($form_id);

$headTitle = trans('Pola formularza "%s"', [$form['name']]);
$breadcrumbs->push($surl("/list"), $headTitle, 'fa-envelope-open-o');
