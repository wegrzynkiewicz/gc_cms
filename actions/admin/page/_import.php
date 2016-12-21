<?php

$page_id = intval($_SEGMENTS[0] == 'list' ? 0 : array_shift($_SEGMENTS));
$headTitle = trans("Strony");
$breadcrumbs->push('/admin/page/list', $headTitle, 'fa-files-o');
