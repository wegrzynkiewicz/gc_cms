<?php

$options = [];
foreach ($settings['options'] as $value) {
    $options[$value] = $value;
}

echo GC\Render::action("/admin/parts/input/selectbox.html.php", [
    'name' => $name,
    'label' => $field['name'],
    'help' => $field['help'],
    'options' => $options,
    'firstOption' => trans('Wybierz jedną z opcji'),
]);
