<?php

$headTitle = trans('Moduły w węźle produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/{$frame_id}/module/grid"),
    'name' => $headTitle,
]);
