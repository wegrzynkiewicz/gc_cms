<?php

$sent_id = intval($_POST['sent_id']);
$sent = GC\Model\Form\Sent::selectByPrimaryId($sent_id);
GC\Model\Form\Sent::deleteByPrimaryId($sent_id);
