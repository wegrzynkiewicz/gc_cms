<?php

require ACTIONS_PATH.'/admin/_import.php';

$module_id = intval(array_shift($_PARAMETERS));

# dodanie ramki
$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'tab',
]);

# pobierz najstarszą pozycję dla zakładki w module
$position = GC\Model\Module\Tab::select()
    ->fields('MAX(position) AS max')
    ->equals('module_id', $module_id)
    ->fetch()['max'];

# wstawienie pozycji zakładki
GC\Model\Module\Tab::insert([
    'module_id' => $module_id,
    'frame_id' => $frame_id,
    'position' => $position + 1,
]);

flashBox($trans('Nowa zakładka "%s" została dodana.', [post('name')]));
http_response_code(204);
