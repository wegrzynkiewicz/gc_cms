<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$headTitle = $trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$refreshUrl = $uri->mask("/edit-views");

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
