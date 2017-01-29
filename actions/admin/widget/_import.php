<?php

$headTitle = $trans('Widżety');
$uri->extendMask('/widget%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'cube',
]);
