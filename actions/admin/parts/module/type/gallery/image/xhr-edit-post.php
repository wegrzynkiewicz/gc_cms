<?php

$file_id = intval(array_shift($_SEGMENTS));
$filePath = WEB_PATH.$_POST['url'];
list($width, $height) = getimagesize($filePath);
$settings = [
    'width' => $width,
    'height' => $height,
];

GC\Model\Module\File::updateByPrimaryId($file_id, [
    'name' => post('name'),
    'url' => post('url'),
    'settings' => json_encode($settings),
]);

header("Content-Type: application/json; charset=utf-8");
http_response_code(204);
