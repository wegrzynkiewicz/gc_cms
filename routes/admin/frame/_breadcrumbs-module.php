<?php

$headTitle = trans(
    $config['frame']['types'][$frame['type']]['labels']['module'],
    [$frame['name']]
);

$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/grid/{$frame_id}"),
    'name' => $headTitle,
]);
