<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

$options = [];
if (isset($field_id) and $field_id > 0) {
    # pobierz meta tagi dla pola formularza
    $meta = GC\Model\Form\Meta::fetchMeta($field_id);
    $options = json_decode($meta['options']);
}

?>
<p><?=$trans('Pole jednokrotnego wyboru wymaga wprowadzenia możliwych wyborów')?></p>

<?=render(ACTIONS_PATH.'/admin/parts/input/select2-tags.html.php', [
    'id' => 'options',
    'name' => 'options',
    'label' => $trans('Możliwe wybory'),
    'help' => $trans('Należy wpisać dostępne dla użytkowników wartości do wybrania. Należy potwierdzić klawiszem ENTER.'),
    'options' => $options,
    'selectedValues' => $options,
])?>
