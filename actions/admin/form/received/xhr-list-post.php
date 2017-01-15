<?php

# utwórz zapytanie dla datatables
$query = GC\Model\Form\Sent::select()
    ->fields(['sent_id', 'name', 'status', 'sent_datetime'])
    ->equals('form_id', $form_id)
    ->buildForDataTables($_POST);

# pobierz ilość przefiltrowanych zgłoszeń dla formularza o $form_id
$filteredQuery = clone $query;
$recordsFiltered = intval($filteredQuery
    ->fields('COUNT(*) AS count')
    ->clearSort()
    ->clearLimit()
    ->fetch()['count']);

# pobierz ilość wszystkich zgłoszeń dla formularza o $form_id
$recordsTotal = intval(GC\Model\Form\Sent::select()
    ->fields('COUNT(*) AS count')
    ->equals('form_id', $form_id)
    ->fetch()['count']);

# kontent jaki zostanie zwrócony
GC\Response::setMimeType('application/json');
echo json_encode([
    'draw' => intval(post('draw', 1)),
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $query->fetchAll(),
]);
