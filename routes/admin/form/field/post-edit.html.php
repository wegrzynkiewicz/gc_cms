<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/form/_import.php';
require ROUTES_PATH.'/admin/form/field/_import.php';

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
require ROUTES_PATH."/admin/form/field/type/{$type}-post.php";

flashBox(trans('Pole "%s" zostało zaktualizowane.', [$field['name']]));
redirect($breadcrumbs->getLast('uri'));
