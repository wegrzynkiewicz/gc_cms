<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

# wstaw pole do tabeli
$field_id = GC\Model\Form\Field::insert([
    'name' => post('name'),
    'type' => post('type'),
    'help' => post('help'),
]);

# pobierz największą pozycję dla pola w formularzu
$position = GC\Model\Form\Position::select()
    ->fields('MAX(position) AS max')
    ->equals('form_id', $form_id)
    ->fetch()['max'];

# wstaw przynależność pola do formularza
GC\Model\Form\Position::insert([
    'form_id' => $form_id,
    'field_id' => $field_id,
    'position' => $position+1,
]);

# wykonaj indywidualną akcję dla innego typu pola formularza
$type = post('type');
require ACTIONS_PATH."/admin/form/field/types/{$type}-post.php";

flashBox(trans('Pole "%s" zostało utworzone.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
