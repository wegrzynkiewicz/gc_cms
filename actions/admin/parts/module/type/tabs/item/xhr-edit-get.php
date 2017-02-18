<?php

require ACTIONS_PATH.'/admin/_import.php';

$frame_id = intval(get('frame_id'));

# pobranie zakładki z ramką
$item = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('frame_id', $frame_id)
    ->fetch();

$_POST = $item;

echo render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => trans('Nazwa pojedyńczej zakładki'),
])?>
