<?php

$file_id = intval(array_shift($_SEGMENTS));
$image = GC\Model\Module\File::fetchByPrimaryId($file_id);
$_POST = $image;

echo GC\Render::action('/admin/parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => 'Krótki tytuł slajdu',
]);

echo GC\Render::action('/admin/parts/input/image.html.php', [
    'name' => 'url',
    'label' => 'Slajd',
    'placeholder' => 'Ścieżka do pliku zdjęcia',
]);
