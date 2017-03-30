<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/popup/_import.php';

$popup_id = intval(array_shift($_PARAMETERS));
if ($popup_id) {
    # pobierz okienko po kluczu głównym
    $popup = GC\Model\PopUp\PopUp::select()
        ->fields('content')
        ->equals('popup_id', $popup_id)
        ->fetch();
    $_POST = $popup;
}

?>

<div class="simple-box">
    <?=render(ROUTES_PATH.'/admin/parts/input/_image.html.php', [
        'name' => 'content',
        'label' => trans('Zdjęcie'),
        'placeholder' => trans('Ścieżka do pliku zdjęcia'),
    ])?>
</div>
