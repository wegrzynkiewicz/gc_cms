<?php

$headTitle = $trans('Kopie zapasowe');
GC\Url::extendMask('/dump%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-database');
$dump_id = intval(array_shift($_PARAMETERS));
