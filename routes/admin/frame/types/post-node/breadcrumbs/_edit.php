<?php

$headTitle = trans('Edycja węzła podziału wpisów: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/frame/{$frame_id}/edit"),
    'name' => $headTitle,
]);
