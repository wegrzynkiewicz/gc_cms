<?php

$headTitle = $trans('Moduły zakładki "%s"', [$item['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask("/list"),
    'name' => $headTitle,
]);
