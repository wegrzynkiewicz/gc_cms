<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Informacje podstawowe')?></legend>
                    <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                        'name' => 'name',
                        'label' => $nameCaption,
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
                        'name' => 'image',
                        'label' => trans('Zdjęcie wyróżniające'),
                        'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH."/admin/frame/type/{$type}/_custom-form.html.php")?>

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Optymalizacja pod wyszukiwarki')?></legend>
                    <?=render(ROUTES_PATH.'/admin/_parts/input/slug.html.php', [
                        'name' => 'slug',
                        'label' => trans('Adres wpisu'),
                        'help' => trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                        'name' => 'title',
                        'label' => trans('Tytuł strony (meta title)'),
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

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia')?></legend>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                        'name' => 'visibility',
                        'label' => trans('Widoczność strony'),
                        'help' => trans('Decyduje o widoczności strony w nawigacji i mapie strony'),
                        'options' => array_trans($config['frameVisibility'])
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/datetimepicker.html.php', [
                        'name' => 'publication_datetime',
                        'label' => trans('Data publikacji strony'),
                        'help' => trans('Zostaw puste, aby ustawieć teraźniejszą datę'),
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz stronę'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
