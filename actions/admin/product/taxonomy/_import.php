<?php

$headTitle = $trans('Podziały produktów');
$uri->extendMask('/taxonomy%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
]);
