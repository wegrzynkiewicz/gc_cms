<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa pola',
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'help',
                    'label' => 'Krótki opis',
                    'help' => 'Warto poinstruować użytkownika co należy wpisać w to pole.',
                ])?>

                <?php if ($field_id == 0): ?>
                    <?=GC\Render::action('/admin/parts/input/selectbox.html.php', [
                        'name' => 'type',
                        'label' => 'Typ pola',
                        'help' => 'Typ pola określa jego wygląd i zachowanie. Typu nie można później zmienić.',
                        'options' => $config['formFieldTypes'],
                        'firstOption' => 'Wybierz typ pola',
                    ])?>
                <?php endif ?>
            </div>

            <div class="simple-box">
                <div id="fieldType">
                    <span class="text-muted">
                        <?=trans('Wybierz typ pola')?>
                    </span>
                </div>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz węzeł',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>

<script>
$(function() {
    function refreshType(fieldType) {
        $.get("<?=$surl(sprintf("%s/types", $field_id ? "/$field_id" : '/'))?>/"+fieldType, function(data) {
            $('#fieldType').html(data);
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
            }
        },
        messages: {
            name: {
                required: "<?=trans('Nazwa pola jest wymagana')?>"
            },
            type: {
                required: "<?=trans('Wybierz typ pola formularza')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
