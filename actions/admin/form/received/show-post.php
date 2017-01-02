<?php

GC\Model\Form\Sent::updateByPrimaryId($sent_id, [
    'status' => $_POST['status'],
]);

setNotice(trans('Status wiadomośći został zaktualizowany.'));

GC\Response::redirect($breadcrumbs->getLastUrl());
