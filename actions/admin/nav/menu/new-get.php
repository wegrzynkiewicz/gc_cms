<?php

$headTitle = $trans('Dodawanie nowego węzła');
$breadcrumbs->push($request->path, $headTitle);

$refreshUrl = GC\Url::mask("/edit-views");

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
