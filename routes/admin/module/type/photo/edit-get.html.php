<?php

require ROUTES_PATH."/admin/module/type/photo/_import.php";

$_POST = $settings;
$_POST['theme'] = $module['theme'];

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa zdjęcia'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/selectbox.html.php', [
                    'name' => 'theme',
                    'label' => trans('Szablon'),
                    'help' => trans('Wybierz jeden z dostępnych szablonów dla zdjęcia'),
                    'options' => $config['moduleThemes']['photo'],
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'uri',
                    'label' => trans('Zdjęcie'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz moduł zdjęcia'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/end.html.php'; ?>
