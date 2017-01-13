<?php

$taxonomy = GC\Model\Post\Taxonomy::fetchByPrimaryId($tax_id);
$headTitle = $trans('%s - węzły', [$taxonomy['name']]);
GC\Url::extendMask("/{$tax_id}/node%s");
$breadcrumbs->push(GC\Url::mask('/tree'), $headTitle);
$node_id = intval(array_shift($_PARAMETERS));
