<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

require_once ACTIONS_PATH.'/admin/module/edit.html.php';
