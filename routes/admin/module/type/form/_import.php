<?php

$headTitle = trans('Edycja modułu formularza');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
