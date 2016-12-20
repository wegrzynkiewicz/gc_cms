<?php

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\ModuleItem::selectWithFrameByPrimaryId($item_id);
$frame_id = $item['frame_id'];

if (isPost()) {

    GC\Model\Frame::updateByPrimaryId($frame_id, [
        'name' => $_POST['name'],
    ]);

    return http_response_code(204);
}

$_POST = $item;

echo view('/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Nazwa pojedyńczej zakładki',
])?>
