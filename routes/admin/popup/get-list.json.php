<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/popup/_import.php";

// utwórz zapytanie dla datatables
$records = GC\Model\PopUp\PopUp::select()
    ->fields('SQL_CALC_FOUND_ROWS popup_id, name, type')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->buildForDataTables($_REQUEST)
    ->fetchAll();

// pobierz ilość przefiltrowanych rekordów
$recordsFiltered = intval(GC\Storage\Database::getInstance()
    ->fetch("SELECT FOUND_ROWS() AS count;")['count']
);

// pobierz ilość wszystkich rekordów
$recordsTotal = intval(GC\Model\PopUp\PopUp::select()
    ->fields('COUNT(*) AS count')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count']
);

foreach ($records as &$record) {
    $record['typeName'] = $config['popupTypes'][$record['type']];
}
unset($record);

// kontent jaki zostanie zwrócony
echo json_encode([
    'draw' => intval($_REQUEST['draw']),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $records,
]);
