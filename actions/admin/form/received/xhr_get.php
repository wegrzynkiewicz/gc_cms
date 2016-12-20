<?php

$form_id = intval(array_shift($_SEGMENTS));

$criteria = GC\Storage\Criteria::createForDataTables($_POST);
$criteria->pushCondition('form_id = ?', [$form_id]);

$records = GC\Model\FormSent::selectByCriteria($criteria);
$filtered = GC\Model\FormSent::countByCriteria($criteria);
$allRecords = GC\Model\FormSent::countByFormId($form_id);

$response = [
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $allRecords,
    'recordsFiltered' => $filtered,
    'data' => $records,
];

echo json_encode($response);
