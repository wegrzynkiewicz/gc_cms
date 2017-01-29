<?php

$headTitle = $trans('Kopie zapasowe');
$uri->extendMask('/dump%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'database',
]);
$dump_id = intval(array_shift($_PARAMETERS));
