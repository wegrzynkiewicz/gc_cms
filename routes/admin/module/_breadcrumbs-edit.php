<?php

$headTitle = trans($config['module']['types'][$module['type']]['labels']);
$breadcrumbs->push([
    'uri' => $uri->make("/admin/module/{$module_id}/edit"),
    'name' => $headTitle,
]);
