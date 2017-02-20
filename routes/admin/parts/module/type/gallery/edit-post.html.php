<?php

require ROUTES_PATH."/admin/parts/module/type/gallery/_import.php";

# aktualizuj galerię zdjęć
GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

# usuń wszystkie rekordy budujące drzewo
GC\Model\Module\FilePosition::delete()
    ->equals('module_id', $module_id)
    ->execute();

# dekoduj nadesłaną wartość positions
$positions = json_decode(post('positions', []), true);

# każdą nadesłaną pozycję wstaw do bazy danych
$position = 1;
foreach ($positions as $image) {
    GC\Model\Module\FilePosition::insert([
        'file_id' => $image['id'],
        'module_id' => $module_id,
        'position' => $position,
    ]);
    $position++;
}

$theme = post('theme');
require ROUTES_PATH."/admin/parts/module/type/gallery/theme/{$theme}-post.php";

flashBox(trans('Moduł galerii zdjęć został zaktualizowany.'));
redirect($breadcrumbs->getBeforeLast('uri'));
