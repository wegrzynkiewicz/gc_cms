<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => post('name'),
    'type' => 'tabs-item',
]);

GC\Model\Module\Item::insertWithModuleId([
    'frame_id' => $frame_id,
], $module_id);

GC\Response::setMimeType('application/json');
http_response_code(204);
