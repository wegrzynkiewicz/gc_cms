<?php

$headTitle = $trans("Widżety");
GC\Url::extendMask('/widget%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-cube');
$widget_id = shiftSegmentAsInteger();
