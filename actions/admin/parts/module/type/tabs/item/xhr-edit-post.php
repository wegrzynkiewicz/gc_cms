<?php

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\ModuleItem::selectWithFrameByPrimaryId($item_id);

GC\Model\Frame::updateByPrimaryId($item['frame_id'], [
    'name' => $_POST['name'],
]);

GC\Response::setMimeType('application/json');
http_response_code(204);
