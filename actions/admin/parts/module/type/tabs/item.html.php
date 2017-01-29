<?php

$headTitle = $trans('Moduły zakładki "%s"', [$item['name']]);
$breadcrumbs->push([
    'url' => $uri->mask("/list"),
    'name' => $headTitle,
]);
