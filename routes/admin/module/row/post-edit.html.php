<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));
$position = intval(array_shift($_PARAMETERS));

$gutter = post('gutter');
$gutter = $gutter === "" ? 30 : intval($gutter);

GC\Model\Module\Row::replace([
    'frame_id' => $frame_id,
    'position' => $position,
    'type' => post('type'),
    'gutter' => $gutter,
    'bg_color' => post('bg_color'),
    'bg_image' => $uri->relative(post('bg_image')),
]);

http_response_code(204);
