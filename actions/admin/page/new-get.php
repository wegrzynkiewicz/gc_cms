<?php

$headTitle = trans('Dodawanie nowej strony');
$breadcrumbs->push($request->path, $headTitle);

require ACTIONS_PATH.'/admin/page/form.html.php';
