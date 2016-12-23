<?php

$field = GC\Model\FormField::selectByPrimaryId($field_id);
$type = $field['type'];

$settings = json_decode($field['settings'], true);

require ACTIONS_PATH."/admin/form/field/types/{$type}-{$request->method}.php";

GC\Model\FormField::updateByPrimaryId($field_id, [
    'name' => $_POST['name'],
    'help' => $_POST['help'],
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

setNotice(trans('Pole "%s" zostało zaktualizowane.', [$field['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
