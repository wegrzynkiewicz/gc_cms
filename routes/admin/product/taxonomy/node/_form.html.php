<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa węzła'),
                ])?>
            </div>

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/slug.html.php', [
                    'name' => 'slug',
                    'label' => trans('Adres węzła'),
                    'help' => trans('Zostaw pusty, aby generować adres na podstawie nazwy'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'keywords',
                    'label' => trans('Tagi i słowa kluczowe (meta keywords)'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/textarea.html.php', [
                    'name' => 'description',
                    'label' => trans('Opis podstrony (meta description)'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/image.html.php', [
                    'name' => 'image',
                    'label' => trans('Zdjęcie wyróżniające'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>
            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz węzeł'),
            ])?>
        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

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
                required: "<?=trans('Nazwa węzła jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
