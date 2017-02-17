<?php

require ACTIONS_PATH.'/auth/_import.php';

$staff = GC\Auth\Staff::createFromSession();
$staff->destroySession();

redirect('/auth/session-expired');
