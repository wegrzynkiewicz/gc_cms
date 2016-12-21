<?php

$headTitle = trans("Strony");

if (intval($_SEGMENTS[0])) {
    $page_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/page{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle, 'fa-files-o');
