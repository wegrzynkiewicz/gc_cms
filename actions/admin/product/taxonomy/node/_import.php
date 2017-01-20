<?php

$tax_id = intval(array_shift($_PARAMETERS));
$taxonomy = GC\Model\Product\Taxonomy::fetchByPrimaryId($tax_id);
$headTitle = $trans('%s - węzły', [$taxonomy['name']]);
GC\Url::extendMask("/{$tax_id}/node%s");
$breadcrumbs->push([
    'url' => GC\Url::mask('/tree'),
    'name' => $headTitle,
]);
