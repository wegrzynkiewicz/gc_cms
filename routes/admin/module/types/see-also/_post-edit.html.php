<?php

// aktualizuj moduł
GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
    'content' => post('content'),
]);

// dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

// usuń wszystkie rekordy budujące drzewo
GC\Model\Module\Tab::delete()
    ->equals('module_id', $module_id)
    ->execute();

// każdą nadesłaną pozycję wstaw do bazy danych
$position = 1;
foreach ($positions as $node) {
    if (isset($node['id'])) {
        GC\Model\Module\Tab::insert([
            'module_id' => $module_id,
            'frame_id' => $node['id'],
            'position' => $position++,
        ]);
    }
}

$theme = post('theme');
require ROUTES_PATH."/admin/module/types/see-also/theme/post-{$theme}.html.php";

flashBox(trans('Moduł: Zobacz także został zaktualizowany.'));
