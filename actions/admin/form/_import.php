<?php

$headTitle = trans("Formularze");

if (intval($_SEGMENTS[0])) {
    $form_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/form{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle, 'fa-envelope-o');
