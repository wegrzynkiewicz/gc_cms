<div class="simple-box">
    <fieldset>
        <legend><?=trans('Optymalizacja pod wyszukiwarki')?></legend>
        <?=render(ROUTES_PATH.'/admin/_parts/input/slug.html.php', [
            'name' => 'slug',
            'label' => trans('Adres wpisu'),
            'help' => trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
        ])?>

        <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
            'name' => 'keywords',
            'label' => trans('Tagi i słowa kluczowe (meta keywords)'),
        ])?>

        <?=render(ROUTES_PATH.'/admin/_parts/input/textarea.html.php', [
            'name' => 'description',
            'label' => trans('Opis podstrony (meta description)'),
        ])?>
    </fieldset>
</div>
