<?php

$product_id = intval(array_shift($_PARAMETERS));

# pobranie produktu wraz z ramką po $product_id
$product = GC\Model\Product\Product::select()
    ->source('::frame')
    ->equals('product_id', $product_id)
    ->fetch();

$headTitle = $trans('Edytowanie produktu "%s"', [$product['name']]);
$breadcrumbs->push([
    'url' => $request->url,
    'name' => $headTitle,
]);

$_POST = $product;

# pobranie kluczy node_id, do których przynależy produkt
$checkedValues = array_keys(GC\Model\Product\Node::select()
    ->fields(['node_id'])
    ->source('::membership')
    ->equals('product_id', $product_id)
    ->fetchByMap('node_id', 'node_id'));

require ACTIONS_PATH.'/admin/product/form.html.php';
