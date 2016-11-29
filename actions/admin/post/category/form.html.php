<?php require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
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
                'label' => 'Nazwa węzła',
            ])?>

            <div id="nodeType"></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/post/category/list/$tax_id",
                'saveLabel' => 'Zapisz stronę',
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
                minlength: 4,
                required: true
            }
        },
        messages: {
            name: {
                minlength: "<?=trans('Nazwa węzła musi być dłuższa niż 4 znaki')?>",
                required: "<?=trans('Nazwa węzła jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
