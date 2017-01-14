<?php

$headTitle = $trans('Dodawanie nowej strony');
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/page/form.html.php';
