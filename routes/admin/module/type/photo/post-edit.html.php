<?php

$url = $_POST['uri'];
$name = post('name');

$filePath = WEB_PATH.$url;
list($width, $height) = getimagesize($filePath);
$settings = [
    'uri' => $url,
    'width' => $width,
    'height' => $height,
];

GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
    'content' => $name,
    'settings' => json_encode($settings),
]);

redirect($breadcrumbs->getBeforeLast('uri'));
