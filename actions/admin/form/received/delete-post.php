<?php

$sent_id = intval($_POST['sent_id']);
$sent = GC\Model\FormSent::selectByPrimaryId($sent_id);
GC\Model\FormSent::deleteByPrimaryId($sent_id);
