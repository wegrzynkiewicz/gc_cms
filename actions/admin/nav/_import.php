<?php

$headTitle = trans("Nawigacje");

if (intval($_SEGMENTS[0])) {
    $nav_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/nav{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle, 'fa-files-o');
