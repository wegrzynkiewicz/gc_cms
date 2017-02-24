<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(request('frame_id'));
$slug = request('slug');
$result = empty($slug) ? 'true' : json_encode(GC\Validate::slug($slug, $frame_id));

echo $result;
