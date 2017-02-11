<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$headTitle = $trans('Dodawanie nowej strony');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/page/form.html.php';
