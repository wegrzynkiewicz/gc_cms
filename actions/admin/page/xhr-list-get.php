<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

# utwórz zapytanie dla datatables
$frames = GC\Model\Frame::select()
    ->fields('SQL_CALC_FOUND_ROWS frame_id, name, image, slug')
    ->equals('type', 'page')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->buildForDataTables($_GET)
    ->fetchAll();

# pobierz ilość przefiltrowanych rusztowań
$recordsFiltered = intval(GC\Storage\Database::getInstance()
    ->fetch("SELECT FOUND_ROWS() AS count;")['count']
);

# pobierz ilość wszystkich rusztowań
$recordsTotal = intval(GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', 'page')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count']
);

# dla każdej strony utwórz miniaturę
foreach ($frames as &$frame) {
    $image = empty($frame['image'])
        ? $uri->assets($config['noImageUrl'])
        : $frame['image'];
    $frame['slug'] = $uri->make($frame['slug']);
    $frame['image'] = GC\Thumb::make($image, 64, 999);
}
unset($frame);

# kontent jaki zostanie zwrócony
header("Content-Type: application/json; charset=utf-8");
echo json_encode([
    'draw' => intval(get('draw', 1)),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $frames,
]);
