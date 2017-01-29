<?php

$headTitle = $trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

$refreshUrl = $uri->mask("/edit-views");

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
