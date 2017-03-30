<?php

$headTitle = trans('Edycja modułu: Zobacz także');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
