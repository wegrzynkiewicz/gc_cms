<?php

$frame_id = shiftSegmentAsInteger();
$frame = GC\Model\Frame::selectByPrimaryId($frame_id);
$settings = json_decode($frame['settings'], true);
if (!isset($settings['rows'])) {
    $settings['rows'] = [];
}
