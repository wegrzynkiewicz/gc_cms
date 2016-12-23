<?php

$headTitle = trans("Dodawanie nowej grupy pracowników");
$breadcrumbs->push($request->path, $headTitle);
$permissions = [];

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
