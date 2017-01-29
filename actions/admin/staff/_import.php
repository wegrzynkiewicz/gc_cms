<?php

$headTitle = $trans('Pracownicy');
$uri->extendMask('/staff%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'users',
]);
