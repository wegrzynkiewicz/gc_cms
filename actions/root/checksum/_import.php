<?php

$headTitle = "Sumy kontrolne plików";
$uri->extendMask('/root/checksum%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);
