<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/node/type/_import.php";

?>
<div class="simple-box">
    <fieldset>
        <legend><?=trans('Ustawienia typu węzła')?></legend>
        <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
            'name' => 'name',
            'label' => trans('Nazwa węzła'),
            'help' => trans('Nazwa węzła jest wymagana w przypadku nieklikalnego węzła')
        ])?>
    </fieldset>
</div>
