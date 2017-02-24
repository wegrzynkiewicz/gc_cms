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
                        'label' => trans('Nazwa strony'),
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
                        'name' => 'image',
                        'label' => trans('Zdjęcie wyróżniające'),
                        'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                    ])?>
                </fieldset>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/seo-box.html.php')?>

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
