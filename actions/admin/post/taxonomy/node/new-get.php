<?php

$headTitle = $trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
