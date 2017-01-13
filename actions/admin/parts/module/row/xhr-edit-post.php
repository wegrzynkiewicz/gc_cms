<?php

if (empty($_POST['gutter']) and $_POST['gutter'] != 0) {
    $_POST['gutter'] = 20;
}

$row_number = intval(array_shift($_SEGMENTS));
$settings['rows'][$row_number] = [
    'widthType' => post('widthType'),
    'bgColor' => post('bgColor'),
    'bgImage' => post('bgImage'),
    'gutter' => post('gutter'),
];

GC\Model\Module\Frame::updateByFrameId($frame_id, [
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

http_response_code(204);
