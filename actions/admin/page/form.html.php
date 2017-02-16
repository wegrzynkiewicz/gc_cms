<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => $trans('Nazwa strony'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/slug.html.php', [
                    'name' => 'slug',
                    'label' => $trans('Adres strony'),
                    'help' => $trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => $trans('Tagi i słowa kluczowe (meta keywords)'),
                    'help' => $trans('(Opcjonalnie)'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => $trans('Opis podstrony (meta description)'),
                    'help' => $trans('(Opcjonalny)'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => $trans('Zdjęcie wyróżniające'),
                    'placeholder' => $trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => $trans('Zapisz stronę'),
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
                required: true,
            },
            slug: {
                remote: {
                    url: "<?=$uri->make("/admin/api/validate/xhr-slug/{$frame_id}")?>",
                },
            },
        },
        messages: {
            name: {
                required: "<?=$trans('Nazwa strony jest wymagana')?>",
            },
            slug: {
                remote: "<?=$trans('Podany adres został już zarezerwowany')?>",
            },
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
