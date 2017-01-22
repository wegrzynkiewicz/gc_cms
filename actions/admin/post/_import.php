<?php

$headTitle = $trans('Wpisy');
GC\Url::extendMask('/post%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'pencil-square-o',
]);
