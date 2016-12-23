<?php

$file_id = intval(array_shift($_SEGMENTS));
$image = GC\Model\ModuleFile::selectByPrimaryId($file_id);
$_POST = $image;

echo GC\Render::action('/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Krótki tytuł zdjęcia',
]);

echo GC\Render::action('/admin/parts/input/image.html.php', [
    'name' => 'url',
    'label' => 'Zdjęcie',
    'placeholder' => 'Ścieżka do pliku zdjęcia',
]);
