<?php

$headTitle = $trans("Widżety");
GC\Url::extendMask('/widget%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'fa-cube',
]);
