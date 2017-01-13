<?php

$headTitle = $trans("Grupy pracowników");
GC\Url::extendMask('/group%s');
$breadcrumbs->push(GC\Url::mask('/list'), $headTitle);
