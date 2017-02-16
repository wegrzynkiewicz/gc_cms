<?php

$module_id = intval(array_shift($_PARAMETERS));

# dodanie ramki
$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'tabs-item',
]);

# dodanie zakładki
$item_id = GC\Model\Module\Item::insert([
    'frame_id' => $frame_id,
]);

# wstawienie pozycji zakładki
GC\Model\Module\ItemPosition::insert([
    'module_id' => $module_id,
    'item_id' => $item_id,
    'position' => GC\Model\Module\ItemPosition::selectMaxPositionBy('module_id', $module_id),
]);

header("Content-Type: application/json; charset=utf-8");
http_response_code(204);
