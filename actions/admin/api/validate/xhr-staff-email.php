<?php

require ACTIONS_PATH.'/admin/_import.php';

$staff_id = intval(array_shift($_PARAMETERS));

header("Content-Type: application/json; charset=utf-8");
echo json_encode(GC\Validate::staffEmail(request('email'), $staff_id));
