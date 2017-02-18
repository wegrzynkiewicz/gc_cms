<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$headTitle = $trans('Dodawanie nowej strony');
$breadcrumbs->push([
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/page/form.html.php';
