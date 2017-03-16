<?php

$headTitle = trans('Wpisy');
$uri->extendMask('/frame%s');
$breadcrumbs->push([
    'uri' => $uri->mask("/list/{$type}"),
    'name' => $headTitle,
    'icon' => 'pencil-square-o',
]);
