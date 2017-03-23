<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa nawigacji'),
                    'help' => trans('W zależności od szablonu, nazwa może zostać wyświetlona odwiedzającemu.'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'maxlevels',
                    'label' => trans('Maksymalna głębokość nawigacji'),
                    'help' => trans('Ogranicza głębokość nawigacji. ( 0 oznacza nieograniczoną głębokość )'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/select2-single.html.php', [
                    'name' => 'workname',
                    'label' => trans('Przyporządkuj nawigację do szablonu'),
                    'help' => trans('Wybierz w którym miejscu chcesz wyświetlać tą nawigację.'),
                    'hideSearch' => true,
                    'options' => array_trans(array_merge(
                        ['' => 'Brak przyporządkowania'],
                        $config['template']['navigations']
                    )),
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz nawigację'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
