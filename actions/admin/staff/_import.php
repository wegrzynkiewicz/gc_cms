<?php

$headTitle = trans("Pracownicy");
GC\Url::extendMask('/staff%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-users');
$staff_id = shiftSegmentAsInteger();
