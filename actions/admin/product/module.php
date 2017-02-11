<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';

$product_id = intval(array_shift($_PARAMETERS));

# pobranie produktu wraz z ramką po $product_id
$product = GC\Model\Product\Product::select()
    ->source('::frame')
    ->equals('product_id', $product_id)
    ->fetch();

$frame_id = $product['frame_id'];

$headTitle = $trans('Moduły produktu "%s"', [$product['name']]);
$uri->extendMask("/{$product_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
]);

$getPreviewUrl = function () use ($product_id) {
    return $uri->make("/product/{$product_id}");
};

$action = array_shift($_SEGMENTS);

require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
