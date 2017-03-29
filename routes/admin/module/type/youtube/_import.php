<?php

$headTitle = trans('Edycja modułu YouTube');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
