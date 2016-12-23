<?php

$url = $_POST['url'];
$name = $_POST['name'];

$filePath = WEB_PATH.$url;
list($width, $height) = getimagesize($filePath);
$settings = [
    'url' => $url,
    'width' => $width,
    'height' => $height,
];

GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => 'default',
    'content' => $name,
    'settings' => json_encode($settings),
]);

GC\Response::redirect($breadcrumbs->getLastUrl());