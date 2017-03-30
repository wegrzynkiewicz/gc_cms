<?php

$headTitle = trans('Edycja węzła podziału produktów: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/{$frame_id}/edit"),
    'name' => $headTitle,
]);
