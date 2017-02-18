<?php

$headTitle = trans('Wpisy');
$uri->extendMask('/post%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'pencil-square-o',
]);
