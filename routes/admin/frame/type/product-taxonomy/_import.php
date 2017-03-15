<?php

$headTitle = trans('Podziały produktów');
$uri->extendMask('/frame%s');
$breadcrumbs->push([
    'uri' => $uri->mask("/list/product-taxonomy"),
    'name' => $headTitle,
]);
