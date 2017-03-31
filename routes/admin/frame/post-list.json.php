<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";

// przefiltrowanie nadesłanej zmiennej
$frameType = GC\Validation\Required::enum('type', array_keys($config['frame']['types']));

// utwórz zapytanie dla datatables
$frames = GC\Model\Frame::select()
    ->fields('SQL_CALC_FOUND_ROWS frame_id, name, image, slug')
    ->equals('type', $frameType)
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->buildForDataTables($_REQUEST)
    ->fetchAll();

// pobierz ilość przefiltrowanych rekordów
$recordsFiltered = intval(GC\Storage\Database::getInstance()
    ->fetch("SELECT FOUND_ROWS() AS count;")['count']
);

// pobierz ilość wszystkich rekordów
$recordsTotal = intval(GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', $frameType)
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count']
);

// dla każdego rusztowania utwórz miniaturkę i wygeneruj linki
foreach ($frames as &$frame) {
    $frame_id = $frame['frame_id'];
    $image = empty($frame['image'])
        ? $config['imageNotAvailableUri']
        : $frame['image'];
    $frame['hrefEdit'] = $uri->make("/admin/frame/{$frame_id}/edit");
    $frame['hrefModule'] = $uri->make("/admin/module/grid/{$frame_id}");
    $frame['hrefSlug'] = $uri->make($frame['slug']);
    $frame['image'] = $uri->root(thumbnail($image, 64, 64));
}
unset($frame);

// kontent jaki zostanie zwrócony
echo json_encode([
    'draw' => intval($_REQUEST['draw']),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $frames,
]);
