<?php

$headTitle = $trans('Grupy pracowników');
$uri->extendMask('/group%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
]);
