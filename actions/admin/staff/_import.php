<?php

$headTitle = $trans('Pracownicy');
GC\Url::extendMask('/staff%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'users',
]);
