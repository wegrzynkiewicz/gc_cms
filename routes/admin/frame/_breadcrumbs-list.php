<?php

$headTitle = trans($config['frame']['types'][$frameType]['labels']['list']);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/list/{$frameType}"),
    'name' => $headTitle,
    'icon' => $config['frame']['types'][$frameType]['icon'],
]);
