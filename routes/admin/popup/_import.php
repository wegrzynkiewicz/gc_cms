<?php

$headTitle = trans('Wyskakujące okienka');
$uri->extendMask('/popup%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'external-link',
]);
