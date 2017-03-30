<?php

$headTitle = trans('Edycja zakładki: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/{$frame_id}/edit"),
    'name' => $headTitle,
]);
