<?php

$options = [];
foreach ($settings['options'] as $value) {
    $options[$value] = $value;
}

echo render(ROUTES_PATH."/admin/parts/input/_selectbox.html.php", [
    'name' => $name,
    'label' => $field['name'],
    'help' => $field['help'],
    'options' => $options,
    'firstOption' => trans('Wybierz jedną z opcji'),
]);
