<?php

$sent_id = intval(array_shift($_PARAMETERS));
GC\Model\Form\Sent::updateByPrimaryId($sent_id, [
    'status' => post('status'),
]);

setNotice($trans('Status wiadomośći został zaktualizowany.'));

GC\Response::redirect($breadcrumbs->getLast('url'));
