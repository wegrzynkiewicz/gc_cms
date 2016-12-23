<?php

$headTitle = trans("Wpisy");
GC\Url::extendMask('/post%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-pencil-square-o');
$post_id = shiftSegmentAsInteger();
