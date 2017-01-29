<?php

$headTitle = $trans('Podziały wpisów');
$uri->extendMask('/taxonomy%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
]);
