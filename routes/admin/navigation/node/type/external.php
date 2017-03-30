<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/navigation/node/type/_import.php';

?>

<div class="simple-box">
    <fieldset>
        <legend><?=trans('Ustawienia typu węzła')?></legend>

        <?=render(ROUTES_PATH.'/admin/parts/input/_editbox.html.php', [
            'name' => 'name',
            'label' => trans('Nazwa węzła'),
            'help' => trans('Nazwa węzła jest wymagana w przypadku adresu')
        ])?>

        <?=render(ROUTES_PATH.'/admin/parts/input/_editbox.html.php', [
            'name' => 'destination',
            'label' => trans('Pełny adres do strony WWW'),
            'help' => trans('Wpisz adres strony do której węzeł ma przekierowywać. (Adres powinien zaczynać się od http)'),
        ])?>

        <?=render(ROUTES_PATH.'/admin/parts/input/_select2-single.html.php', [
            'name' => 'target',
            'label' => trans('Sposób przekierowania'),
            'options' => $config['navigation']['nodeTargets'],
            'hideSearch' => true,
        ])?>
    </fieldset>
</div>
