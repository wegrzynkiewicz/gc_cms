<?php

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\ModuleItem::selectWithFrameByPrimaryId($item_id);
$_POST = $item;

echo GC\Render::action('/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Nazwa pojedyńczej zakładki',
])?>
