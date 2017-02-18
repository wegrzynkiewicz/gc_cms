<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/_import.php';
require ACTIONS_PATH.'/admin/product/taxonomy/node/_import.php';

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/product/taxonomy/node/form.html.php';
