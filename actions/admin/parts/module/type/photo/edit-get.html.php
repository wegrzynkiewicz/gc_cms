<?php

$_POST = $settings;
$_POST['name'] = $content;
$_POST['theme'] = $module['theme'];

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa zdjęcia',
                ])?>

                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
                    'name' => 'theme',
                    'label' => 'Szablon',
                    'help' => 'Wybierz jeden z dostępnych szablonów dla zdjęcia',
                    'options' => $config['moduleThemes']['photo'],
                ])?>

                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'url',
                    'label' => 'Zdjęcie',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz moduł zdjęcia',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
