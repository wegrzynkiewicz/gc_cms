<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'name',
                    'label' => trans('Nazwa zdjęcia'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_selectbox.html.php", [
                    'name' => 'theme',
                    'label' => trans('Szablon'),
                    'help' => trans('Wybierz jeden z dostępnych szablonów dla zdjęcia'),
                    'options' => $config['moduleThemes']['photo'],
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_image.html.php", [
                    'name' => 'uri',
                    'label' => trans('Zdjęcie'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz moduł zdjęcia'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
