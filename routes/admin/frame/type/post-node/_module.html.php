<?php

$headTitle = trans('Moduły w węźle wpisu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);
