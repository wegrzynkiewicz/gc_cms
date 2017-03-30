<?php

$headTitle = trans('Moduły w węźle produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/grid/{$frame_id}"),
    'name' => $headTitle,
]);
