<div class="simple-box">
    <fieldset>
        <legend><?=trans('Ustawienia szablonu galerii')?></legend>

        <?=render(ROUTES_PATH.'/admin/parts/input/_select2-single.html.php', [
            'name' => 'thumbnailsPerRow',
            'label' => trans('Ilość miniaturek na wiersz galerii'),
            'hideSearch' => true,
            'options' => [
                12 => 12,
                6 => 6,
                4 => 4,
                3 => 3,
                2 => 2,
                1 => 1,
            ],
        ])?>

        <?=render(ROUTES_PATH.'/admin/parts/input/_editbox.html.php', [
            'name' => 'gutter',
            'label' => trans('Odstęp pomiędzy miniaturkami (w pikselach)'),
            'help' => trans('Ustawia odstęp w pikselach pomiędzy miniaturkami w wierszu.'),
        ])?>
    </fieldset>
</div>
