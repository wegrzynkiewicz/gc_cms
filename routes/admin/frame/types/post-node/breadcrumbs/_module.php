<?php

$headTitle = trans('Moduły w węźle wpisu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/grid/{$frame_id}"),
    'name' => $headTitle,
]);
