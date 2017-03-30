<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$frame_id = intval(array_shift($_PARAMETERS));
$position = intval(array_shift($_PARAMETERS));

$row = GC\Model\Module\Row::select()
    ->equals('frame_id', $frame_id)
    ->equals('position', $position)
    ->fetch();

if ($row) {
    $_POST = $row;
}

?>

<?=render(ROUTES_PATH.'/admin/_parts/input/select2-single.html.php', [
    'name' => 'type',
    'label' => trans('Szerokość wiersza'),
    'help' => trans('Określa zachowanie szerokości wiersza względem szerokości strony.'),
    'hideSearch' => true,
    'options' => array_filter([
        'wrap' => trans('Wyśrodkowany wiersz węższy od dostępnej szerokości'),
        'fluid' => trans('Rozciągnięty wiersz na całą dostępną szerokość'),
    ]),
])?>

<?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
    'name' => 'gutter',
    'label' => trans('Odstęp kafelków (w pikselach)'),
    'help' => trans('Ustawia odstęp w pikselach pomiędzy modułami w wierszu.'),
])?>

<?=render(ROUTES_PATH.'/admin/_parts/input/colorpicker.html.php', [
    'name' => 'bg_color',
    'label' => trans('Kolor tła'),
    'help' => trans('Pozwala na wybranie koloru tła wiersza. Zostaw puste jeżeli nie chcesz ustawiać koloru.'),
])?>

<?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
    'name' => 'bg_image',
    'label' => trans('Zdjęcie tła'),
    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
    'help' => trans('Pozwala na wybranie zdjęcia w tle wiersza. Zostaw puste jeżeli nie chcesz zdjęcia tła.'),
])?>
