<?php

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\Module\Item::selectWithFrameByPrimaryId($item_id);

GC\Model\Module\Frame::updateByPrimaryId($item['frame_id'], [
    'name' => post('name'),
]);

header("Content-Type: application/json; charset=utf-8");
http_response_code(204);
