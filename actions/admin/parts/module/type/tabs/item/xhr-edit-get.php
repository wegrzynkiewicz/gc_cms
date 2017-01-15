<?php

$item_id = intval(array_shift($_SEGMENTS));
$item = GC\Model\Module\Item::selectWithFrameByPrimaryId($item_id);
$_POST = $item;

echo GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Nazwa pojedyńczej zakładki',
])?>
