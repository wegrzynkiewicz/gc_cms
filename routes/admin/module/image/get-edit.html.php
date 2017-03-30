<?php

require ROUTES_PATH."/admin/_import.php";

$file_id = intval(array_shift($_PARAMETERS));
$image = GC\Model\File::fetchByPrimaryId($file_id);
$_POST = $image;

?>
<?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
    'name' => 'name',
    'label' => trans('Krótki tytuł zdjęcia'),
])?>

<?=render(ROUTES_PATH."/admin/parts/input/_image.html.php", [
    'name' => 'slug',
    'label' => trans('Zdjęcie'),
    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
])?>
