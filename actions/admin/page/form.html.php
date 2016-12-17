<?php require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=view('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa strony',
                ])?>

                <?=view('/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => 'Tagi i słowa kluczowe (meta keywords)',
                ])?>

                <?=view('/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => 'Opis podstrony (meta description)',
                ])?>

                <?=view('/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => 'Zdjęcie wyróżniające',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz stronę',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                minlength: 4,
                required: true
            }
        },
        messages: {
            name: {
                minlength: "<?=trans('Nazwa strony musi być dłuższa niż 4 znaki')?>",
                required: "<?=trans('Nazwa strony jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
