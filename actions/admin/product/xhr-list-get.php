<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';

# utwórz zapytanie dla datatables
$products = GC\Model\Product\Product::select()
    ->fields('SQL_CALC_FOUND_ROWS product_id, name, image')
    ->source('::frame')
    ->buildForDataTables($_GET)
    ->fetchAll();

# pobierz ilość przefiltrowanych produktów
$recordsFiltered = intval(GC\Storage\Database::getInstance()
    ->fetch("SELECT FOUND_ROWS() AS count;")['count']
);

# pobierz ilość wszystkich produktów
$recordsTotal = intval(GC\Model\Product\Product::select()
    ->fields('COUNT(*) AS count')
    ->fetch()['count']
);

# dla każdego produktu utwórz miniaturę
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
