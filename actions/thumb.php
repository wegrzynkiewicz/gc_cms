<?php

if (count($_SEGMENTS) !== 3) {
    return http_response_code(400);
}

$imageUrl64 = array_shift($_SEGMENTS);
$token = array_shift($_SEGMENTS);
$thumbWidth = array_shift($_SEGMENTS);
$imageUrl = base64_decode($imageUrl64);
$imagePath = ".".rootUrl($imageUrl);

if (!is_readable($imagePath)) {
    return http_response_code(400);
}

$ratio = floor($thumbWidth/30);
$thumbWidth = ($ratio+1)*30;

list($imageWidth) = getimagesize($imagePath);

if ($thumbWidth > $imageWidth) {
    $thumbWidth = $imageWidth;
}

$thumb = new GC\Thumb($imageUrl, $thumbWidth, 99999);
if (!$thumb->exists()) {

    if (!isset($_SESSION['generateThumb'])) {
        return http_response_code(403);
    }

    if (!isset($_SESSION['generateThumb'][$imageUrl])) {
        return http_response_code(404);
    }

    if ($_SESSION['generateThumb'][$imageUrl] != $token) {
        return http_response_code(401);
    }

    unset($_SESSION['generateThumb'][$imageUrl]);

    if (!$thumb->generate()) {
        return http_response_code(500);
    }
}

unset($_SESSION['generateThumb']);

$thumbPath = ".".$thumb->getUrl();
$filePointer = fopen($thumbPath, 'rb');
$extension = strtolower(pathinfo($thumbPath, PATHINFO_EXTENSION));

header("Content-Type: image/$extension");
header("Content-Length:".filesize($thumbPath));

fpassthru($filePointer);
