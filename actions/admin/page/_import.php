<?php

$headTitle = $trans("Strony");
GC\Url::extendMask('/page%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle, 'fa-files-o');
$page_id = intval(array_shift($_PARAMETERS));
