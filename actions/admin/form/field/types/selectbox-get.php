<?php

$options = [];
if ($field_id > 0) {
    $field = GC\Model\Form\Field::fetchByPrimaryId($field_id);
    $settings = json_decode($field['settings'], true);
    $options = $settings['options'];
}

?>
<p><?=$trans('Pole jednokrotnego wyboru wymaga wprowadzenia możliwych wyborów')?></p>

<?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/select2-tags.html.php', [
    'id' => 'options',
    'name' => 'options',
    'label' => 'Możliwe wybory',
    'help' => 'Należy wpisać dostępne dla użytkowników wartości do wybrania. Należy potwierdzić klawiszem ENTER.',
    'options' => $options,
    'selectedValues' => $options,
])?>
