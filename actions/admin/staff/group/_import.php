<?php

$headTitle = trans("Grupy pracowników");

if (intval($_SEGMENTS[0])) {
    $group_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/group{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle);
