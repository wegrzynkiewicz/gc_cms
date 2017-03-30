<?php

$headTitle = trans('Moduły wpisu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/grid/{$frame_id}"),
    'name' => $headTitle,
]);
