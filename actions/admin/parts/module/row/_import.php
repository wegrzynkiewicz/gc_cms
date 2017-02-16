<?php

$frame_id = intval(array_shift($_PARAMETERS));
$frame = GC\Model\Frame::fetchByPrimaryId($frame_id);
$settings = json_decode($frame['settings'], true);
if (!isset($settings['rows'])) {
    $settings['rows'] = [];
}
