<?php

$tax_id = intval(array_pop($_SEGMENTS));
$taxonomy = GC\Model\PostTaxonomy::selectByPrimaryId($tax_id);

$headTitle = trans('Podział "%s"', [$taxonomy['name']]);
$breadcrumbs->push(taxonomyNodeUrl('/list'), $headTitle);
