<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa pola'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'help',
                    'label' => trans('Krótki opis'),
                    'help' => trans('Warto poinstruować użytkownika co należy wpisać w to pole.'),
                ])?>

                <?php if (!isset($fieldType)): ?>
                    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                        'name' => 'type',
                        'label' => trans('Typ pola'),
                        'help' => trans('Typ pola określa jego wygląd i zachowanie. Typu nie można później zmienić.'),
                        'options' => array_trans($config['formFieldTypes']),
                        'firstOption' => trans('Wybierz typ pola'),
                    ])?>
                <?php endif ?>
            </div>

            <div class="simple-box">
                <div id="fieldType">
                    <?php if (isset($fieldType)): ?>
                        <?=$fieldType?>
                    <?php else: ?>
                        <span class="text-muted">
                            <?=trans('Wybierz typ pola')?>
                        </span>
                    <?php endif ?>
                </div>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz węzeł'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
