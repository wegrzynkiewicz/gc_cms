<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

$field_id = intval(array_shift($_PARAMETERS));

# pobierz pole po kluczu głównym
$field = GC\Model\Form\Field::fetchByPrimaryId($field_id);

# zaktualizuj pole po kluczu głównym
GC\Model\Form\Field::updateByPrimaryId($field_id, [
    'name' => post('name'),
    'help' => post('help'),
]);

# wykonaj indywidualną akcję dla innego typu pola formularza
$type = $field['type'];
require ACTIONS_PATH."/admin/form/field/types/{$type}-post.php";

flashBox($trans('Pole "%s" zostało zaktualizowane.', [$field['name']]));
redirect($breadcrumbs->getLast('uri'));
