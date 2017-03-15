<?php

$taxonomy_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/frame/type/product-taxonomy/_breadcrumb.php";

$headTitle = trans('Dodawanie nowego węzła produktu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

display(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa produktu'),
]);
