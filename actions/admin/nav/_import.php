<?php

$headTitle = $trans('Nawigacje');
GC\Url::extendMask('/nav%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'sitemap',
]);
