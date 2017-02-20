<?php

$module_id = intval(array_shift($_PARAMETERS));

foreach (post('urls', []) as $imageUri) {

    $imageUri = $uri->relative($imageUri);

    # pobieranie informacji o zdjęciu
    $imagePath = WEB_PATH.$imageUri;
    list($width, $height) = getimagesize($imagePath);

    # dodanie zdjęcia do bazy danych
    $file_id = GC\Model\Module\File::insert([
        'slug' => $imageUri,
        'width' => $width,
        'height' => $height,
        'size' => filesize($imagePath),
    ]);

    # pobierz najstarszą pozycję dla pliku w module
    $position = GC\Model\Module\FilePosition::select()
        ->fields('MAX(position) AS max')
        ->equals('module_id', $module_id)
        ->fetch()['max'];

    # dodanie pozycji w module
    GC\Model\Module\FilePosition::insert([
        'file_id' => $file_id,
        'module_id' => $module_id,
        'position' => $position + 1,
    ]);
}
