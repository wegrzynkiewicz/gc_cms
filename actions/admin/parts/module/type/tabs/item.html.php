<?php

$headTitle = $trans('Moduły zakładki "%s"', [$item['name']]);
$breadcrumbs->push([
    'url' => GC\Url::mask("/list"),
    'name' => $headTitle,
]);
