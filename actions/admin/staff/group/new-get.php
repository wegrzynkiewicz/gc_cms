<?php

$headTitle = $trans("Dodawanie nowej grupy pracowników");
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);
$permissions = [];

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
