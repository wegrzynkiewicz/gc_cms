<?php

$tax_id = intval(array_shift($_PARAMETERS));

# pobranei taksonomii po kluczu głównym
$taxonomy = GC\Model\Product\Taxonomy::fetchByPrimaryId($tax_id);

$headTitle = $trans('%s - węzły', [$taxonomy['name']]);
$uri->extendMask("/{$tax_id}/node%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/tree'),
    'name' => $headTitle,
]);
