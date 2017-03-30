<?php

$headTitle = trans('Edycja strony: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/{$frame_id}/edit"),
    'name' => $headTitle,
]);
