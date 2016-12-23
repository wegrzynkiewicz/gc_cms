<?php

$frame_id = GC\Model\Frame::insert([
    'name' => $_POST['name'],
    'type' => 'tabs-item',
]);

GC\Model\ModuleItem::insertWithModuleId([
    'frame_id' => $frame_id,
], $module_id);

return http_response_code(204);
