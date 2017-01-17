<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => post('name'),
    'type' => 'tabs-item',
]);

GC\Model\Module\Item::insertWithModuleId([
    'frame_id' => $frame_id,
], $module_id);

header("Content-Type: application/json; charset=utf-8");
http_response_code(204);
