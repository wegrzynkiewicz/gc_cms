<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';
require ACTIONS_PATH.'/admin/staff/group/_import.php';

$headTitle = trans('Dodawanie nowej grupy pracowników');
$breadcrumbs->push([
    'name' => $headTitle,
]);
$permissions = [];

require ACTIONS_PATH.'/admin/staff/group/form.html.php';
