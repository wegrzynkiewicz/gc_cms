<?php

$headTitle = trans("Pracownicy");

if (intval($_SEGMENTS[0])) {
    $staff_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/staff{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle, 'fa-users');
