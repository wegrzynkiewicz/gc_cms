<?php

$headTitle = trans('Edycja modułu slajdera zdjęć');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
