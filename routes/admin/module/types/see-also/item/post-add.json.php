<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";

$module_id = intval(array_shift($_PARAMETERS));
$frame_id = intval(post('frame_id'));

# pobierz stronę po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

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

flashBox(trans('Dodano nową stronę "%s" do modułu: Zobacz także', [$frame['name']]));
http_response_code(204);
