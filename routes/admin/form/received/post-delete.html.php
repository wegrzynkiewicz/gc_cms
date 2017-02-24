<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/form/_import.php';
require ROUTES_PATH.'/admin/form/received/_import.php';

$sent_id = intval($_POST['sent_id']);
$sent = GC\Model\Form\Sent::fetchByPrimaryId($sent_id);
GC\Model\Form\Sent::deleteByPrimaryId($sent_id);
