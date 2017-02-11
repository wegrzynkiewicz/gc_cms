<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/received/_import.php';

$sent_id = intval(array_shift($_PARAMETERS));
GC\Model\Form\Sent::updateByPrimaryId($sent_id, [
    'status' => post('status'),
]);

setNotice($trans('Status wiadomośći został zaktualizowany.'));

redirect($breadcrumbs->getLast('uri'));
