<?php

require ACTIONS_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));
$slug = request('slug');

header("Content-Type: application/json; charset=utf-8");
echo empty($slug) ? 'true' : json_encode(GC\Validate::slug($slug, $frame_id));
