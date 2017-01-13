<?php

$headTitle = $trans('Podziały wpisów');
GC\Url::extendMask('/taxonomy%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle);
$tax_id = shiftSegmentAsInteger();
