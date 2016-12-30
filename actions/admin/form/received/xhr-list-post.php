<?php

$criteria = GC\Storage\Criteria::createForDataTables($_POST);
$criteria->pushCondition('form_id = ?', [$form_id]);

$records = GC\Model\FormSent::selectAllByCriteria(['sent_id', 'name', 'status', 'sent_datetime'], $criteria);
$filtered = GC\Model\FormSent::countByCriteria($criteria);
$allRecords = GC\Model\FormSent::countBy('form_id', $form_id);

$response = [
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $allRecords,
    'recordsFiltered' => $filtered,
    'data' => $records,
];

GC\Response::setMimeType('application/json');
echo json_encode($response);
