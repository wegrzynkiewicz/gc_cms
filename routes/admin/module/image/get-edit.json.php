<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$file_id = intval(array_shift($_PARAMETERS));
$image = GC\Model\File::fetchByPrimaryId($file_id);
$_POST = $image;

?>
<?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
    'name' => 'name',
    'label' => trans('Krótki tytuł zdjęcia'),
])?>

<?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
    'name' => 'slug',
    'label' => trans('Zdjęcie'),
    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
])?>
