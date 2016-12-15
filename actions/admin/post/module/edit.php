<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

require_once ACTIONS_PATH.'/admin/parts/module/edit.html.php';
