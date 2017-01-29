<?php

$headTitle = $trans('Wpisy');
$uri->extendMask('/post%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'pencil-square-o',
]);
