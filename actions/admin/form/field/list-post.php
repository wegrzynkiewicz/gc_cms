<?php

$positions = json_decode($_POST['positions'], true);
$positions = array_filter($positions, function ($node) {
    return isset($node['id']);
});
GC\Model\Form\Position::updatePositionByFormId($form_id, $positions);

setNotice(trans('Pozycja pól została zapisana.'));

GC\Response::redirect($breadcrumbs->getLastUrl());
