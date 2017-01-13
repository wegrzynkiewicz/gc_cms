<?php

$headTitle = $trans("Nawigacje");
GC\Url::extendMask('/nav%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-sitemap');
$nav_id = shiftSegmentAsInteger();
