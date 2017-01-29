<?php

$headTitle = $trans('Strony');
$uri->extendMask('/page%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'files-o',
]);
