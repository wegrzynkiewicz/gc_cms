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

            <?=view('/admin/parts/input/selectbox.html.php', [
                'name' => 'type',
                'label' => 'Typ węzła',
                'help' => 'Wybierz typ węzła nawigacji w menu',
                'options' => $config['nodeTypes'],
                'firstOption' => 'Wybierz typ węzła',
            ])?>

            <div id="nodeType"></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/nav-node/list/$nav_id",
                'saveLabel' => 'Zapisz stronę',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function() {
    function refreshType(nodeType) {
        $.get("<?=url("/admin/nav-node/edit-views")?>/"+nodeType+"/<?=$node_id?>", function(data) {
            $('#nodeType').html(data);
        });
    }
    $('#type').change(function() {
        refreshType($(this).val());
    });

    <?php if (isset($nodeType)): ?>
        refreshType("<?=$nodeType?>");
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
