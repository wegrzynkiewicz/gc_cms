<?php require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'name',
                'label' => 'Nazwa galerii',
            ])?>

            <?=view('/admin/parts/input/selectbox.html.php', [
                'name' => 'lang',
                'label' => 'Język galerii',
                'help' => 'Wybierz język dla tytułów zdjęć nowej galerii',
                'options' => $config['langs'],
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/gallery/list",
                'saveLabel' => 'Zapisz galerię',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                minlength: 6,
                required: true
            },
        },
        messages: {
            name: {
                minlength: "<?=trans('Nazwa galerii musi być dłuższa niż 6 znaków')?>",
                required: "<?=trans('Nazwa galerii jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
