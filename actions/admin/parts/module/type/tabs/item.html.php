<?php

$headTitle = $trans('Moduły zakładki "%s"', [$item['name']]);
$breadcrumbs->push(GC\Url::mask("/list"), $headTitle);
