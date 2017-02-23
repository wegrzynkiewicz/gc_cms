<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/popup/_import.php';

?>

<div class="simple-box">
    <?=render(ROUTES_PATH.'/admin/parts/input/image.html.php', [
        'name' => 'content',
        'label' => trans('Zdjęcie'),
        'placeholder' => trans('Ścieżka do pliku zdjęcia'),
    ])?>
</div>
