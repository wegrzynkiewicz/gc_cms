<?php

$headTitle = $trans('Kopie zapasowe');
GC\Url::extendMask('/dump%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'database',
]);
$dump_id = intval(array_shift($_PARAMETERS));
