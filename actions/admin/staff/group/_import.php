<?php

$headTitle = $trans('Grupy pracowników');
$uri->extendMask('/group%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);
