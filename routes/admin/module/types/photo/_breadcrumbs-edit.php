<?php

$headTitle = trans('Edycja modułu zdjęcia');
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
