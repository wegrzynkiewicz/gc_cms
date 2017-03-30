<?php

require ROUTES_PATH.'/admin/_import.php';

$file_id = intval(array_shift($_PARAMETERS));
$imageUri = $uri->relative(post('slug'));

# pobieranie informacji o zdjęciu
$imagePath = WEB_PATH.$imageUri;
list($width, $height) = getimagesize($imagePath);

# aktualizacja zdjęcia w bazie danych
GC\Model\File::updateByPrimaryId($file_id, [
    'slug' => $imageUri,
    'name' => post('name'),
    'width' => $width,
    'height' => $height,
    'size' => filesize($imagePath),
]);

http_response_code(204);
