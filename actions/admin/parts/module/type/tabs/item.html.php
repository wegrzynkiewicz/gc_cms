<?php

$headTitle = trans('Moduły zakładki "%s"', [$item['name']]);
$breadcrumbs->push(GC\Url::make("/list"), $headTitle);
