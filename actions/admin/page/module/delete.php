<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

require_once ACTIONS_PATH.'/admin/parts/module/delete.html.php';
