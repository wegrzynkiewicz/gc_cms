<?php

$headTitle = trans('Moduły w węźle produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);
