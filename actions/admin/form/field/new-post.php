<?php

$type = $_POST['type'];
$settings = [];

require ACTIONS_PATH."/admin/form/field/types/{$type}-{$request->method}.php";

GC\Model\Form\Position::insert([
    'form_id' => $form_id,
    'field_id' => GC\Model\Form\Field::insert([
        'name' => post('name'),
        'type' => post('type'),
        'help' => post('help'),
        'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
    ]),
    'position' => GC\Model\Form\Position::selectMaxPositionBy('form_id', $form_id),
]);

setNotice($trans('Pole "%s" zostało utworzone.', [$_POST['name']]));
GC\Response::redirect($breadcrumbs->getLastUrl());
