<?php

$file_id = intval(array_shift($_SEGMENTS));
$filePath = WEB_PATH.$_POST['uri'];
list($width, $height) = getimagesize($filePath);
$settings = [
    'width' => $width,
    'height' => $height,
];

GC\Model\Module\File::updateByPrimaryId($file_id, [
    'name' => post('name'),
    'uri' => post('uri'),
    'settings' => json_encode($settings),
]);

http_response_code(204);
