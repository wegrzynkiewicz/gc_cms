<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/form/_import.php";
require ROUTES_PATH."/admin/form/field/_import.php";

$field_id = intval($_POST['field_id']);

# pobierz pole po kluczu głównym
$field = GC\Model\Form\Field::fetchByPrimaryId($field_id);

# usuń pole po kluczu głównym
GC\Model\Form\Field::deleteByPrimaryId($field_id);

flashBox(trans('Pole "%s" zostało usunięte.', [$field['name']]));
redirect($breadcrumbs->getLast()['uri']);
