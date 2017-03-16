<?php

$headTitle = trans('Moduły podziału produktów: %s', [$frame['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask('/grid'),
    'name' => $headTitle,
]);
