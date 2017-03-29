<?php

$headTitle = trans('Nawigacje');
$breadcrumbs->push([
    'uri' => $uri->make('/admin/navigation/list'),
    'name' => $headTitle,
    'icon' => 'sitemap',
]);
