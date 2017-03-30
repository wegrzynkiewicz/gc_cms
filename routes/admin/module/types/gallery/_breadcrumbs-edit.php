<?php

$headTitle = trans('Edycja modułu galerii zdjęć');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
