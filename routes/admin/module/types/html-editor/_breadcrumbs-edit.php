<?php

$headTitle = trans('Edycja modułu tekstowego');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
