<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">
            <div class="simple-box">
                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa węzła',
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => 'Tagi i słowa kluczowe (meta keywords)',
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => 'Opis podstrony (meta description)',
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => 'Zdjęcie wyróżniające',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>
            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz węzeł',
            ])?>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "<?=$trans('Nazwa węzła jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>