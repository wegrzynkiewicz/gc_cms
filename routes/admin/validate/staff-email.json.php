<?php

require ROUTES_PATH.'/admin/_import.php';

$staff_id = intval(array_shift($_PARAMETERS));
$result = GC\Validate::staffEmail(request('email'), $staff_id);

echo json_encode($result);
