<?php

$item_id = intval(array_pop($_PARAMETERS));

# pobranie zakładki z ramką
$item = GC\Model\Module\Item::select()
    ->source('::frame')
    ->equals('item_id', $item_id)
    ->fetch();

GC\Model\Frame::updateByPrimaryId($item['frame_id'], [
    'name' => post('name'),
]);

http_response_code(204);
