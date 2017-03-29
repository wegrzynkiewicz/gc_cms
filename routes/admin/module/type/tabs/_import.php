<?php

$headTitle = trans('Edycja modułu zakładek');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
