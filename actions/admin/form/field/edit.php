<?php

$field_id = intval(array_shift($_SEGMENTS));

$field = GC\Model\FormField::selectByPrimaryId($field_id);
$type = $field['type'];

$headTitle = trans('Edycja pola "%s"', [$field['name']]);
$breadcrumbs->push($request, $headTitle);

if(isPost()) {

    $settings = json_decode($field['settings'], true);

    require_once ACTIONS_PATH."/admin/form/field/types/$type.php";

    GC\Model\FormField::updateByPrimaryId($field_id, [
        'name' => $_POST['name'],
        'help' => $_POST['help'],
        'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
    ]);

    setNotice(trans('Pole "%s" zostało zaktualizowane.', [$field['name']]));

	redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $field;

require_once ACTIONS_PATH.'/admin/form/field/form.html.php';
