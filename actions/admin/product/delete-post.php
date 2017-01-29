<?php

$product_id = intval(post('product_id'));

# pobranie produktu wraz z ramką po $product_id
$product = GC\Model\Product\Product::select()
    ->source('::frame')
    ->equals('product_id', $product_id)
    ->fetch();

GC\Model\Product\Product::deleteFrameByPrimaryId($product_id);

setNotice($trans('Produkt "%s" została usunięta.', [$product['name']]));
redirect($breadcrumbs->getLast('uri'));
