<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";

$module_id = intval(array_shift($_PARAMETERS));

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

# usuń wszystkie rekordy budujące drzewo
GC\Model\Module\Tab::delete()
    ->equals('module_id', $module_id)
    ->execute();

# każdą nadesłaną pozycję wstaw do bazy danych
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

flashBox(trans('Kolejność zakładek została zaktualizowana.'));
http_response_code(204);
