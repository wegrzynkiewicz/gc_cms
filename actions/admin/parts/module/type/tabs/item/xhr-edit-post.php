<?php

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\Module\Item::selectWithFrameByPrimaryId($item_id);

GC\Model\Module\Frame::updateByPrimaryId($item['frame_id'], [
    'name' => post('name'),
]);

GC\Response::setMimeType('application/json');
http_response_code(204);
