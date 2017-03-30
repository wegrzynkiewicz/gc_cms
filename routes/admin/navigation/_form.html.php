<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'name',
                    'label' => trans('Nazwa nawigacji'),
                    'help' => trans('W zależności od szablonu, nazwa może zostać wyświetlona odwiedzającemu.'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'maxlevels',
                    'label' => trans('Maksymalna głębokość nawigacji'),
                    'help' => trans('Ogranicza głębokość nawigacji. ( 0 oznacza nieograniczoną głębokość )'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_select2-single.html.php", [
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

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz nawigację'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/assets/_footer.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
