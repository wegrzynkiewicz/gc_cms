<?php

$headTitle = trans('Moduły produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/grid/{$frame_id}"),
    'name' => $headTitle,
]);
