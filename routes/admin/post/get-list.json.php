<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';

# utwórz zapytanie dla datatables
$frames = GC\Model\Frame::select()
    ->fields('SQL_CALC_FOUND_ROWS frame_id, name, image, slug')
    ->equals('type', 'post')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->buildForDataTables($_GET)
    ->fetchAll();

# pobierz ilość przefiltrowanych rekordów
$recordsFiltered = intval(GC\Storage\Database::getInstance()
    ->fetch("SELECT FOUND_ROWS() AS count;")['count']
);

# pobierz ilość wszystkich rekordów
$recordsTotal = intval(GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', 'post')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count']
);

# dla każdego rusztowania utwórz miniaturkę i wygeneruj linki
foreach ($frames as &$frame) {
    $frame_id = $frame['frame_id'];
    $image = empty($frame['image'])
        ? $config['noImageUri']
        : $frame['image'];
    $frame['hrefEdit'] = $uri->mask("/{$frame_id}/edit");
    $frame['hrefGrid'] = $uri->mask("/{$frame_id}/module/grid");
    $frame['hrefSlug'] = $uri->make($frame['slug']);
    $frame['image'] = $uri->root(thumbnail($image, 64, 64));
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
