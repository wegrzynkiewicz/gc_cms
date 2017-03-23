<?php

$module_id = intval(array_shift($_PARAMETERS));

$meta = GC\Model\Module\Meta::fetchMeta($module_id);
$meta['gutter'] = $meta['gutter'] ?: 20;

$_POST = $meta;

?>
<div class="simple-box">
    <fieldset>
        <legend><?=trans('Ustawienia szablonu galerii')?></legend>

        <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
            'name' => 'thumbnailsPerRow',
            'label' => trans('Ilość miniaturek na wiersz galerii'),
            'options' => [
                12 => 12,
                6 => 6,
                4 => 4,
                3 => 3,
                2 => 2,
                1 => 1,
            ]
        ])?>

        <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
            'name' => 'gutter',
            'label' => trans('Odstęp pomiędzy miniaturkami (w pikselach)'),
            'help' => trans('Ustawia odstęp w pikselach pomiędzy miniaturkami w wierszu.'),
        ])?>
    </fieldset>
</div>
