<?php

require ROUTES_PATH."/admin/_import.php";

$module_id = intval(array_shift($_PARAMETERS));

$urls = $_POST['urls'] ?? [];

foreach ($urls as $imageUri) {

    $imageUri = $uri->relative($imageUri);

    // pobieranie informacji o zdjęciu
    $imagePath = WEB_PATH.$imageUri;
    list($width, $height) = getimagesize($imagePath);

    // dodanie zdjęcia do bazy danych
    $file_id = GC\Model\File::insert([
        'slug' => $imageUri,
        'width' => $width,
        'height' => $height,
        'name' => '',
        'size' => filesize($imagePath),
    ]);

    // pobierz najstarszą pozycję dla pliku w module
    $position = GC\Model\Module\FileRelation::select()
        ->fields('MAX(position) AS max')
        ->equals('module_id', $module_id)
        ->fetch()['max'];

    // dodanie pozycji w module
    GC\Model\Module\FileRelation::insert([
        'module_id' => $module_id,
        'file_id' => $file_id,
        'position' => $position + 1,
    ]);
}

http_response_code(204);
