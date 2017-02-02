<?php

# utwórz zapytanie dla datatables
$query = GC\Model\Product\Product::select()
    ->fields(['product_id', 'name', 'image'])
    ->source('::frame')
    ->buildForDataTables($_GET);

# pobierz ilość przefiltrowanych produktów
$filteredQuery = clone $query;
$recordsFiltered = intval($filteredQuery
    ->fields('COUNT(*) AS count')
    ->clearSort()
    ->clearLimit()
    ->fetch()['count']);

# pobierz ilość wszystkich produktów
$recordsTotal = intval(GC\Model\Product\Product::select()
    ->fields('COUNT(*) AS count')
    ->fetch()['count']);

# dla każdego produktu utwórz miniaturę
$products = $query->fetchAll();
foreach ($products as &$product) {
    $image = empty($product['image'])
        ? $uri->assets($config['noImageUrl'])
        : $product['image'];
    $product['image'] = GC\Thumb::make($image, 64, 999);
}
unset($product);

# kontent jaki zostanie zwrócony
header("Content-Type: application/json; charset=utf-8");
echo json_encode([
    'draw' => intval(post('draw', 1)),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $products,
]);
