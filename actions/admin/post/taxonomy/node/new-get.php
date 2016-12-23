<?php

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push($request->path, $headTitle);

require ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
