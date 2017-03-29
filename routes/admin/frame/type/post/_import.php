<?php

$headTitle = trans('Wpisy');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/list/{$type}"),
    'name' => $headTitle,
    'icon' => 'pencil-square-o',
]);
