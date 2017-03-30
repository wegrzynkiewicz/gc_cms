<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/form/_import.php";
require ROUTES_PATH."/admin/form/field/_import.php";

# przefiltruj aby wyeliminować nieprawidłowe id
$positions = json_decode($_POST['positions'], true);
$positions = array_filter($positions, function ($node) {
    return isset($node['id']);
});

# usuń pozycje pól w formularzu
GC\Model\Form\Position::delete()
    ->equals('form_id', $form_id)
    ->execute();

# wstaw na nowo pozycje pól w formularzu
$position = 1;
foreach ($positions as $field) {
    GC\Model\Form\Position::insert([
        'form_id' => $form_id,
        'field_id' => intval($field['id']),
        'position' => $position++,
    ]);
}

flashBox(trans('Pozycja pól została zapisana.'));
redirect($breadcrumbs->getLast()['uri']);
