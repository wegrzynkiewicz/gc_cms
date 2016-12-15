<?php

$nav_id = intval(array_pop($_SEGMENTS));
$nav = GC\Model\MenuTaxonomy::selectByPrimaryId($nav_id);

$headTitle = trans('Węzły nawigacji "%s"', [$nav['name']]);
$breadcrumbs->push("/admin/nav/menu/list/$nav_id", $headTitle);
