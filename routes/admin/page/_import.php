<?php

$headTitle = trans('Strony');
$uri->extendMask('/page%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'files-o',
]);
