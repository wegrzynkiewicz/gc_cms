<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));
$slug = request('slug');

echo empty($slug) ? 'true' : json_encode(GC\Validate::slug($slug, $frame_id));
