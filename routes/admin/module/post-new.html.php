<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$frame_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH.'/admin/module/parts/_breadcrumbs-loop.php';

$moduleType = post('type');

# wstaw moduł
$module_id = GC\Model\Module::insert([
    'type' => $moduleType,
    'theme' => 'default',
    'content' => '',
]);

# pobierz największą pozycję Y w gridzie
$y = GC\Model\Module\Grid::select()
    ->fields('MAX(y) AS max')
    ->equals('frame_id', $frame_id)
    ->fetch();

# wylicz pozycję Y jako ostatni element grida
$y = (isset($y['max'])) ? $y['max'] + 1 : 0;

# wstaw pozycję modułu w gridzie
GC\Model\Module\Grid::insert([
    'frame_id' => $frame_id,
    'module_id' => $module_id,
    'x' => 0,
    'y' => $y,
    'w' => 12,
    'h' => 1,
]);

# wstaw ustawienia wiersza
GC\Model\Module\Row::replace([
    'frame_id' => $frame_id,
    'position' => $y,
    'gutter' => 30,
    'bg_image' => '',
]);

flashBox(trans("%s został utworzony. Edytujesz go teraz.", [$config['module']['types'][$moduleType]['name']]));
redirect($uri->make("/admin/module/{$module_id}/edit"));
