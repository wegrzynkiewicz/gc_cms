<?php

$file_id = intval(array_shift($_SEGMENTS));
$filePath = WEB_PATH.$_POST['url'];
list($width, $height) = getimagesize($filePath);
$settings = [
    'width' => $width,
    'height' => $height,
];

GC\Model\ModuleFile::updateByPrimaryId($file_id, [
    'name' => $_POST['name'],
    'url' => $_POST['url'],
    'settings' => json_encode($settings),
]);

return http_response_code(204);