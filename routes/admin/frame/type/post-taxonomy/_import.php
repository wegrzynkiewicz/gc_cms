<?php

$headTitle = trans('Podziały wpisów');
$uri->extendMask('/frame%s');
$breadcrumbs->push([
    'uri' => $uri->mask("/list/post-taxonomy"),
    'name' => $headTitle,
]);
