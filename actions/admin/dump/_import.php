<?php

$headTitle = $trans('Kopie zapasowe');
GC\Url::extendMask('/dump%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-database');
$dump_id = shiftSegmentAsInteger();
