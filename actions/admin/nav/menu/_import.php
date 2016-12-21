<?php

if (intval($_SEGMENTS[0])) {
    $menu_id = intval(array_shift($_SEGMENTS));
} else {
    $menu_id = 0;
}

$surl = function($path) use ($surl, $nav_id) {
    return $surl("/{$nav_id}/menu{$path}");
};

$nav = GC\Model\MenuTaxonomy::selectByPrimaryId($nav_id);

$headTitle = trans('Węzły nawigacji "%s"', [$nav['name']]);
$breadcrumbs->push($surl("/list"), $headTitle);
