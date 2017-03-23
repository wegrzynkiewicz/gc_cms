<?php

require ROUTES_PATH.'/admin/_import.php';
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

<?=render(ROUTES_PATH.'/admin/_parts/input/ckeditor.html.php', [
    'name' => 'content',
    'options' => [
         'customConfig' => $uri->root('/assets/admin/ckeditor-full.js'),
    ],
])?>
