<?php

$item_id = intval(array_pop($_PARAMETERS));

# pobranie zakładki z ramką
$item = GC\Model\Module\Item::select()
    ->source('::frame')
    ->equals('item_id', $item_id)
    ->fetch();

$_POST = $item;

echo GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Nazwa pojedyńczej zakładki',
])?>
