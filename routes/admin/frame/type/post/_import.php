<?php

$headTitle = trans('Wpisy');
$uri->extendMask('/frame%s');
$breadcrumbs->push([
    'uri' => $uri->mask("/list/post"),
    'name' => $headTitle,
    'icon' => 'files-o',
]);
