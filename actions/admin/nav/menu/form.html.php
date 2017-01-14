<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa węzła',
                ])?>

                <?=GC\Render::action('/admin/parts/input/selectbox.html.php', [
                    'name' => 'type',
                    'label' => 'Typ węzła',
                    'help' => 'Wybierz typ węzła nawigacji w menu',
                    'options' => GC\Data::get('config')['nodeTypes'],
                    'firstOption' => 'Wybierz typ węzła',
                ])?>
            </div>

            <div class="simple-box">
                <div id="nodeType">
                    <?=$trans('Wybierz typ węzła')?>
                </div>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz węzeł',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function() {
    function refreshType(nodeType) {
        $.get("<?=$refreshUrl?>/"+nodeType, function(data) {
            $('#nodeType').html(data);
        });
    }
    $('#type').change(function() {
        refreshType($(this).val());
    });

    <?php if (isset($_POST['type'])): ?>
        refreshType("<?=e($_POST['type'])?>");
    <?php endif ?>
});
</script>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
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
                required: "<?=$trans('Nazwa węzła jest wymagana')?>"
            },
            type: {
                required: "<?=$trans('Wybierz typ węzła')?>"
            },
            destination: {
                required: "<?=$trans('Podaj gdzie ma kierować węzeł')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
