<?php

foreach ($_POST['urls'] as $url) {

    $filePath = WEB_PATH.$url;
    list($width, $height) = getimagesize($filePath);
    $settings = [
        'width' => $width,
        'height' => $height,
    ];

    GC\Model\Module\File::insertWithModuleId([
        'url' => GC\Url::upload($url),
        'settings' => json_encode($settings),
    ], $module_id);
}
