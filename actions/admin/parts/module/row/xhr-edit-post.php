<?php

if (empty($_POST['gutter']) and $_POST['gutter'] != 0) {
    $_POST['gutter'] = 20;
}

$row_number = intval(array_shift($_SEGMENTS));
$settings['rows'][$row_number] = [
    'widthType' => $_POST['widthType'],
    'bgColor' => $_POST['bgColor'],
    'bgImage' => $_POST['bgImage'],
    'gutter' => $_POST['gutter'],
];

GC\Model\Frame::updateByFrameId($frame_id, [
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

http_response_code(204);
