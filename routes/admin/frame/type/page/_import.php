<?php

$headTitle = trans('Strony');
$uri->extendMask('/frame%s');
$breadcrumbs->push([
    'uri' => $uri->mask("/list/{$type}"),
    'name' => $headTitle,
    'icon' => 'files-o',
]);
