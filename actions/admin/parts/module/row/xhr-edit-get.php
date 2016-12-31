<?php

$row_number = intval(array_shift($_SEGMENTS));
if (isset($settings['rows'][$row_number])) {
    $_POST = $settings['rows'][$row_number];
}

if (!isset($_POST['gutter'])) {
    $_POST['gutter'] = 20;
}

echo GC\Render::action('/admin/parts/input/selectbox.html.php', [
    'name' => 'widthType',
    'label' => 'Szerokość wiersza',
    'help' => 'Określa zachowanie szerokości wiersza względem szerokości strony.',
    'options' => [
        'wrap' => 'Wyśrodkowany wiersz węższy od szerokości strony',
        'fluid' => 'Rozciągnięty wiersz na całą szerokość strony',
    ],
]);

echo GC\Render::action('/admin/parts/input/editbox.html.php', [
    'name' => 'gutter',
    'label' => 'Odstęp kafelków (w pikselach)',
    'help' => 'Ustawia odstęp w pikselach pomiędzy modułami w wierszu.',
]);

echo GC\Render::action('/admin/parts/input/colorpicker.html.php', [
    'name' => 'bgColor',
    'label' => 'Kolor tła',
    'help' => 'Pozwala na wybranie koloru tła wiersza. Zostaw puste jeżeli nie chcesz ustawiać koloru.',
]);

echo GC\Render::action('/admin/parts/input/image.html.php', [
    'name' => 'bgImage',
    'label' => 'Zdjęcie tła',
    'placeholder' => 'Ścieżka do pliku zdjęcia',
    'help' => 'Pozwala na wybranie zdjęcia w tle wiersza. Zostaw puste jeżeli nie chcesz zdjęcia tła.',
]);
