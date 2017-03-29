<?php

$headTitle = trans('Pracownicy');
$breadcrumbs->push([
    'uri' => $uri->make('/admin/staff/list'),
    'name' => $headTitle,
    'icon' => 'users',
]);
