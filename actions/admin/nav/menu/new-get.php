<?php

$headTitle = $trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$refreshUrl = GC\Url::mask("/edit-views");

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
