<?php

$headTitle = $trans('Podziały wpisów');
$uri->extendMask('/taxonomy%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);
