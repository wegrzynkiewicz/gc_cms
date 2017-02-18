<?php

$file_id = intval(array_shift($_SEGMENTS));
$image = GC\Model\Module\File::fetchByPrimaryId($file_id);
$_POST = $image;

echo render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => trans('Krótki tytuł zdjęcia'),
]);

echo render(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
    'name' => 'uri',
    'label' => trans('Zdjęcie'),
    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
]);
