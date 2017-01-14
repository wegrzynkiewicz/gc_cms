<?php

$headTitle = $trans('Podziały wpisów');
GC\Url::extendMask('/taxonomy%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
]);
