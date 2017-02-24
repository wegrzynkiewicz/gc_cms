<?php

require ROUTES_PATH.'/admin/_import.php';

$staff_id = intval(array_shift($_PARAMETERS));

echo json_encode(GC\Validate::staffEmail(request('email'), $staff_id));
