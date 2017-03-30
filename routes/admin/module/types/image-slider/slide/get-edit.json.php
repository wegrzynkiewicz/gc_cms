<?php

$file_id = intval(array_shift($_SEGMENTS));
$image = GC\Model\Module\FileRelation::fetchByPrimaryId($file_id);
$_POST = $image;

echo render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => trans('Krótki tytuł slajdu'),
]);

echo render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
    'name' => 'uri',
    'label' => trans('Slajd'),
    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
]);
