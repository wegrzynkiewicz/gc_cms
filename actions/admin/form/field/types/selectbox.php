<?php

if(isPost()) {
    $settings['options'] = $_POST['options'];

    return;
} else {
    $field_id = intval(array_shift($_SEGMENTS));
    $options = [];

    if ($field_id > 0) {
        $field = GC\Model\FormField::selectByPrimaryId($field_id);
        $settings = json_decode($field['settings'], true);
        $options = $settings['options'];
    }
}

?>

<p><?=trans('Pole jednokrotnego wyboru wymaga wprowadzenia możliwych wyborów')?></p>

<?=view('/admin/parts/input/select2-tags.html.php', [
    'id' => 'options',
    'name' => 'options',
    'label' => 'Możliwe wybory',
    'help' => 'Należy wpisać dostępne dla użytkowników wartości do wybrania. Klawisz ENTER rozdziela wartości',
    'options' => $options,
    'selectedValues' => $options,
])?>
