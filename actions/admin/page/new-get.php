<?php

$headTitle = $trans('Dodawanie nowej strony');
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/page/form.html.php';
