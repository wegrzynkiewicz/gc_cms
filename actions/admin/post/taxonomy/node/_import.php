<?php

$taxonomy = GC\Model\Post\Taxonomy::selectByPrimaryId($tax_id);
$headTitle = trans('%s - węzły', [$taxonomy['name']]);
GC\Url::extendMask("/{$tax_id}/node%s");
$breadcrumbs->push(GC\Url::mask('/tree'), $headTitle);
$node_id = shiftSegmentAsInteger();
