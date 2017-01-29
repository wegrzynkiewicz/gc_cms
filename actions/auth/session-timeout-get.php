<?php

$staff = GC\Auth\Staff::createFromSession();
$staff->destroySession();

redirect('/auth/session-expired');
