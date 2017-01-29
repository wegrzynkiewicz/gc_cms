<?php

$headTitle = $trans('Dodawanie nowego produktu');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

# wartości do jakich węzłów należy produkt
$checkedValues = [];

require ACTIONS_PATH.'/admin/product/form.html.php';
