<?php

$headTitle = trans("Widżety");

if (intval($_SEGMENTS[0])) {
    $widget_id = intval(array_shift($_SEGMENTS));
}

$surl = function($path) use ($surl) {
    return $surl("/widget{$path}");
};

$breadcrumbs->push($surl('/list'), $headTitle, 'fa-cube');
