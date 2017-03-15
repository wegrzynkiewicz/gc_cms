<?php

$headTitle = trans('Moduły produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);
