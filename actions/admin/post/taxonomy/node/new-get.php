<?php

$headTitle = $trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

require ACTIONS_PATH.'/admin/post/taxonomy/node/form.html.php';
