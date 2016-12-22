<?php

$headTitle = trans('Dodawanie nowego pola');
$breadcrumbs->push($request, $headTitle);

$field_id = 0;

if(isPost()) {

    $type = $_POST['type'];
    $settings = [];

    require ACTIONS_PATH."/admin/form/field/types/$type.php";

    GC\Model\FormField::insertWithFormId([
        'name' => $_POST['name'],
        'type' => $type,
        'help' => $_POST['help'],
        'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
    ], $form_id);

    setNotice(trans('Pole "%s" zostało utworzone.', [$_POST['name']]));

	redirect($breadcrumbs->getBeforeLastUrl());
}

require ACTIONS_PATH.'/admin/form/field/form.html.php';
