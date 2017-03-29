<?php

$headTitle = trans('Kopie zapasowe');
$breadcrumbs->push([
    'uri' => $uri->make('/admin/dump/list'),
    'name' => $headTitle,
    'icon' => 'database',
]);
$dump_id = intval(array_shift($_PARAMETERS));
