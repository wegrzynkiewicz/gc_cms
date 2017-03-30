<?php

$taxonomy_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/frame/parts/_taxonomy-breadcrumbs.php";

$headTitle = trans('Dodawanie nowego węzła produktu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH."/admin/frame/parts/_form.html.php", [
    'nameCaption' => trans('Nazwa węzła wpisu'),
]);
