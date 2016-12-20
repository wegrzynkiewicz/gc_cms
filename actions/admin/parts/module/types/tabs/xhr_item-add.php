<?php

if (isPost()) {

    $module_id = intval(array_shift($_SEGMENTS));

    $frame_id = GC\Model\Frame::insert([
        'name' => $_POST['name'],
        'type' => 'tabs-item',
    ]);

    GC\Model\ModuleItem::insertWithModuleId([
        'frame_id' => $frame_id,
    ], $module_id);

    return http_response_code(204);
}

echo view('/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Nazwa pojedyńczej zakładki',
])?>
