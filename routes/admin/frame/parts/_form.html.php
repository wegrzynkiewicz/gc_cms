<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Informacje podstawowe')?></legend>
                    <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                        'name' => 'name',
                        'label' => $nameCaption,
                        'attributes' => [
                            'data-validation' => 'required',
                            'data-validation-error-msg-required' => trans('Nazwa jest wymagana'),
                        ],
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_image.html.php", [
                        'name' => 'image',
                        'label' => trans('Zdjęcie wyróżniające'),
                        'attributes' => [
                            'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                        ],
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH."/admin/frame/types/{$frameType}/_custom-form.html.php")?>

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Optymalizacja pod wyszukiwarki')?></legend>
                    <?=render(ROUTES_PATH."/admin/parts/input/_slug.html.php", [
                        'name' => 'slug',
                        'label' => trans('Adres wpisu'),
                        'help' => trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
                        'attributes' => [
                            'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                            'data-validation' => 'server',
                            'data-validation-url' => $uri->make("/admin/validate/slug.json", [
                                'frame_id' => $frame_id,
                            ]),
                            'data-validation-optional' => 'true',
                        ],
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                        'name' => 'title',
                        'label' => trans('Tytuł strony (meta title)'),
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                        'name' => 'keywords',
                        'label' => trans('Tagi i słowa kluczowe (meta keywords)'),
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_textarea.html.php", [
                        'name' => 'description',
                        'label' => trans('Opis podstrony (meta description)'),
                    ])?>
                </fieldset>
            </div>

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia')?></legend>

                    <?=render(ROUTES_PATH."/admin/parts/input/_selectbox.html.php", [
                        'name' => 'visibility',
                        'label' => trans('Widoczność strony'),
                        'help' => trans('Decyduje o widoczności strony w nawigacji i mapie strony'),
                        'options' => array_trans($config['frame']['visibility'])
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_datetimepicker.html.php", [
                        'name' => 'publication_datetime',
                        'label' => trans('Data publikacji strony'),
                        'help' => trans('Zostaw puste, aby ustawieć teraźniejszą datę'),
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz stronę'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/assets/_footer.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
