<?php

$nav = GC\Model\Menu\Taxonomy::fetchByPrimaryId($nav_id);
$headTitle = $trans('Wezły: %s', [$nav['name']]);
GC\Url::extendMask("/{$nav_id}/menu%s");
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle);
$menu_id = intval(array_shift($_PARAMETERS));
