<?php

require ACTIONS_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

header("Content-Type: application/json; charset=utf-8");
echo json_encode(GC\Validate::slug(request('slug'), $frame_id));
