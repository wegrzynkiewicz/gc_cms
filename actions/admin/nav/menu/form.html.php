<?php require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'name',
                'label' => 'Nazwa węzła',
            ])?>

            <?=view('/admin/parts/input/selectbox.html.php', [
                'name' => 'type',
                'label' => 'Typ węzła',
                'help' => 'Wybierz typ węzła nawigacji w menu',
                'options' => $config['nodeTypes'],
                'firstOption' => 'Wybierz typ węzła',
            ])?>

            <div id="nodeType"></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz stronę',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function() {
    function refreshType(nodeType) {
        $.get("<?=url("/admin/nav/menu/edit-views")?>/"+nodeType+"/<?=e($menu_id)?>", function(data) {
            $('#nodeType').html(data);
        });
    }
    $('#type').change(function() {
        refreshType($(this).val());
    });

    <?php if (isset($nodeType)): ?>
        refreshType("<?=e($nodeType)?>");
    <?php endif ?>
});
</script>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                minlength: 4,
                required: true
            },
            type: {
                required: true
            },
            destination: {
                required: true
            }
        },
        messages: {
            name: {
                minlength: "<?=trans('Nazwa węzła musi być dłuższa niż 4 znaki')?>",
                required: "<?=trans('Nazwa węzła jest wymagana')?>"
            },
            type: {
                required: "<?=trans('Wybierz typ węzła')?>"
            },
            destination: {
                required: "<?=trans('Podaj gdzie ma kierować węzeł')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
