<?php

$moduleType = post('type');

# wstaw moduł
$module_id = GC\Model\Module\Module::insert([
    'type' => $moduleType,
    'theme' => 'default',
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

flashBox(trans("%s został utworzony. Edytujesz go teraz.", [$config['modules'][$moduleType]['name']]));
redirect($uri->mask("/{$module_id}/edit"));
