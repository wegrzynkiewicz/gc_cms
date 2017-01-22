<?php

$headTitle = $trans('Strony');
GC\Url::extendMask('/page%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'files-o',
]);
