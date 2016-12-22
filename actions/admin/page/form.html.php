<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa strony',
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => 'Tagi i słowa kluczowe (meta keywords)',
                ])?>

                <?=GC\Render::action('/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => 'Opis podstrony (meta description)',
                ])?>

                <?=GC\Render::action('/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => 'Zdjęcie wyróżniające',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz stronę',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "<?=trans('Nazwa strony jest wymagana')?>",
            },
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
