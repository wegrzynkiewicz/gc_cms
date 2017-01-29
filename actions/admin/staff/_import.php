<?php

$headTitle = $trans('Pracownicy');
$uri->extendMask('/staff%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'users',
]);
