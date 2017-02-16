<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

$positions = json_decode($_POST['positions'], true);
$positions = array_filter($positions, function ($node) {
    return isset($node['id']);
});

GC\Model\Form\Position::delete()->equals('form_id', $form_id)->execute();
$pos = 1;
foreach ($positions as $field) {
    GC\Model\Form\Position::insert([
        'form_id' => $form_id,
        'field_id' => $field['id'],
        'position' => $pos++,
    ]);
}

flashBox($trans('Pozycja pól została zapisana.'));

redirect($breadcrumbs->getLast('uri'));
