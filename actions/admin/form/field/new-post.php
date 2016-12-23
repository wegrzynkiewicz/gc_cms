<?php

$type = $_POST['type'];
$settings = [];

require ACTIONS_PATH."/admin/form/field/types/{$type}-{$request->method}.php";

GC\Model\FormField::insertWithFormId([
    'name' => $_POST['name'],
    'type' => $type,
    'help' => $_POST['help'],
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
], $form_id);

setNotice(trans('Pole "%s" zostało utworzone.', [$_POST['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
