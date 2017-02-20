<?php

$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);
$settings = json_decode($module['settings'], true);

if (!isset($settings['gutter'])) {
    $settings['gutter'] = 20;
}

$_POST = $settings;

?>

<div class="simple-box">
    <fieldset>
        <legend><?=trans('Ustawienia szablonu')?></legend>

        <?=render(ROUTES_PATH.'/admin/parts/input/selectbox.html.php', [
            'name' => 'thumbsPerRow',
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

        <?=render(ROUTES_PATH.'/admin/parts/input/editbox.html.php', [
            'name' => 'gutter',
            'label' => trans('Odstęp pomiędzy miniaturkami (w pikselach)'),
            'help' => trans('Ustawia odstęp w pikselach pomiędzy miniaturkami w wierszu.'),
        ])?>
    </fieldset>
</div>
