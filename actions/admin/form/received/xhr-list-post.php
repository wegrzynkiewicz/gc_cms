<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/received/_import.php';

# utwórz zapytanie dla datatables
$received = $query = GC\Model\Form\Sent::select()
    ->fields('SQL_CALC_FOUND_ROWS sent_id, name, status, sent_datetime')
    ->equals('form_id', $form_id)
    ->buildForDataTables($_POST)
    ->fetchAll();

# pobierz ilość przefiltrowanych zgłoszeń
$recordsFiltered = intval(GC\Storage\Database::getInstance()
    ->fetch("SELECT FOUND_ROWS() AS count;")['count']
);

# pobierz ilość wszystkich zgłoszeń dla formularza o $form_id
$recordsTotal = intval(GC\Model\Form\Sent::select()
    ->fields('COUNT(*) AS count')
    ->equals('form_id', $form_id)
    ->fetch()['count']);

# kontent jaki zostanie zwrócony
header("Content-Type: application/json; charset=utf-8");
echo json_encode([
    'draw' => intval(post('draw', 1)),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $received,
]);
