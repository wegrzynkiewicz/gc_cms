<?php

$positions = json_decode($_POST['positions'], true);
$positions = array_filter($positions, function ($node) {
    return isset($node['id']);
});

GC\Model\Form\Position::deleteAllBy('form_id', $form_id);
$pos = 1;
foreach ($positions as $field) {
    GC\Model\Form\Position::insert([
        'form_id' => $form_id,
        'field_id' => $field['id'],
        'position' => $pos++,
    ]);
}

setNotice(trans('Pozycja pól została zapisana.'));

GC\Response::redirect($breadcrumbs->getLastUrl());
