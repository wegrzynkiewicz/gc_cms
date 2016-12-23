<?php

$headTitle = trans('Dodawanie nowego wpisu');
$breadcrumbs->push($request->path, $headTitle);

$checkedValues = [];

require ACTIONS_PATH.'/admin/post/form.html.php';
