<?php

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push([
    'name' => $headTitle,
]);

require ROUTES_PATH.'/admin/post/taxonomy/node/form.html.php';
