<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

require_once ACTIONS_PATH.'/admin/module/delete.html.php';
