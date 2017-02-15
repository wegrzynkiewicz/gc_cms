<?php

$row_number = intval(array_shift($_SEGMENTS));
if (isset($settings['rows'][$row_number])) {
    $_POST = $settings['rows'][$row_number];
}

if (!isset($_POST['gutter'])) {
    $_POST['gutter'] = 20;
}

echo render(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
    'name' => 'widthType',
    'label' => $trans('Szerokość wiersza'),
    'help' => $trans('Określa zachowanie szerokości wiersza względem szerokości strony.'),
    'options' => [
        'wrap' => 'Wyśrodkowany wiersz węższy od szerokości strony',
        'fluid' => 'Rozciągnięty wiersz na całą szerokość strony',
    ],
]);

echo render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
    'name' => 'gutter',
    'label' => $trans('Odstęp kafelków (w pikselach)'),
    'help' => $trans('Ustawia odstęp w pikselach pomiędzy modułami w wierszu.'),
]);

echo render(ACTIONS_PATH.'/admin/parts/input/colorpicker.html.php', [
    'name' => 'bgColor',
    'label' => $trans('Kolor tła'),
    'help' => $trans('Pozwala na wybranie koloru tła wiersza. Zostaw puste jeżeli nie chcesz ustawiać koloru.'),
]);

echo render(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
    'name' => 'bgImage',
    'label' => $trans('Zdjęcie tła'),
    'placeholder' => $trans('Ścieżka do pliku zdjęcia'),
    'help' => $trans('Pozwala na wybranie zdjęcia w tle wiersza. Zostaw puste jeżeli nie chcesz zdjęcia tła.'),
]);
