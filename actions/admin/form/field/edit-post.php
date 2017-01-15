<?php

$field_id = intval(array_shift($_PARAMETERS));
$field = GC\Model\Form\Field::fetchByPrimaryId($field_id);
$type = $field['type'];

$settings = json_decode($field['settings'], true);

require ACTIONS_PATH."/admin/form/field/types/{$type}-{$request->method}.php";

GC\Model\Form\Field::updateByPrimaryId($field_id, [
    'name' => post('name'),
    'help' => post('help'),
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

setNotice($trans('Pole "%s" zostało zaktualizowane.', [$field['name']]));

GC\Response::redirect($breadcrumbs->getLast('url'));
