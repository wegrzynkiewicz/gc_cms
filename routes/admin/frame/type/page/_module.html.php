<?php

$headTitle = trans('Moduły strony: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);
