<?php

$headTitle = $trans('Podziały produktów');
GC\Url::extendMask('/taxonomy%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
]);
