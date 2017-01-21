<?php

$module_id = intval(array_shift($_PARAMETERS));

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

# usuń wszystkie rekordy budujące drzewo
GC\Model\Module\ItemPosition::delete()
    ->equals('module_id', $module_id)
    ->execute();

# każdą nadesłaną pozycję wstaw do bazy danych
$pos = 1;
foreach ($positions as $node) {
    if (isset($node['id'])) {
        GC\Model\Module\ItemPosition::insert([
            'module_id' => $module_id,
            'file_id' => $node['id'],
            'position' => $pos++,
        ]);
    }
}

http_response_code(204);
