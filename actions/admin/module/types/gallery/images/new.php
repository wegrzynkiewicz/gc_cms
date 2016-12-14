<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));

foreach ($_POST['urls'] as $url) {

    $filePath = "./$url";
    list($width, $height) = getimagesize($filePath);
    $settings = [
        'width' => $width,
        'height' => $height,
    ];

    ModuleFile::insert([
        'url' => uploadUrl($url),
        'settings' => json_encode($settings),
    ], $module_id);
}
