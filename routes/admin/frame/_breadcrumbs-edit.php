<?php

$headTitle = trans($config['frame']['types'][$frame['type']]['labels']['edit'], [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/{$frame_id}/edit"),
    'name' => $headTitle,
    'icon' => $config['frame']['types'][$frame['type']]['icon'],
]);
