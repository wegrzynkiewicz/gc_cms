<?php

require ROUTES_PATH."/admin/_import.php";

$frame_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/module/parts/_breadcrumbs-loop.php";

// dekoduj nadesłaną wartość
$grid = json_decode(post('grid'), true);

// usuń wszystkie pozycje z grida dla zadanego rusztowania
GC\Model\Module\Grid::delete()
    ->equals('frame_id', $frame_id)
    ->execute();

// dodaj po kolei każdego grida
foreach ($grid as $module) {
    GC\Model\Module\Grid::insert([
        'frame_id' => $frame_id,
        'module_id' => $module['id'],
        'x' => $module['x'],
        'y' => $module['y'],
        'w' => $module['width'],
        'h' => $module['height'],
    ]);
}

flashBox(trans('Ustawienia kafelków zostały zapisane.'));
redirect($breadcrumbs->getLast()['uri']);
