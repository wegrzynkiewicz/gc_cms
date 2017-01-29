<?php

$headTitle = $trans('Widżety');
$uri->extendMask('/widget%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'cube',
]);
