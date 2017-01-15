<?php

$headTitle = $trans('Grupy pracowników');
GC\Url::extendMask('/group%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
]);
