<?php

$headTitle = $trans('Podziały produktów');
$uri->extendMask('/taxonomy%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);
