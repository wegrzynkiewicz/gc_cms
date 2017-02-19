<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/nav/_import.php';
require ROUTES_PATH.'/admin/nav/menu/_import.php';

?>

<div class="simple-box">
    <?=render(ROUTES_PATH.'/admin/parts/input/editbox.html.php', [
        'name' => 'destination',
        'label' => trans('Pełny adres do strony WWW'),
        'help' => trans('Wpisz adres strony do której węzeł ma przekierowywać'),
    ])?>

    <?=render(ROUTES_PATH.'/admin/parts/input/selectbox.html.php', [
        'name' => 'target',
        'label' => trans('Sposób załadowania adresu'),
        'options' => $config['navNodeTargets'],
    ])?>
</div>
