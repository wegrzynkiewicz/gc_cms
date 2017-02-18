<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa pola'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'help',
                    'label' => trans('Krótki opis'),
                    'help' => trans('Warto poinstruować użytkownika co należy wpisać w to pole.'),
                ])?>

                <?php if (!isset($fieldType)): ?>
                    <?=render(ACTIONS_PATH.'/admin/parts/input/selectbox.html.php', [
                        'name' => 'type',
                        'label' => trans('Typ pola'),
                        'help' => trans('Typ pola określa jego wygląd i zachowanie. Typu nie można później zmienić.'),
                        'options' => array_trans($config['formFieldTypes']),
                        'firstOption' => trans('Wybierz typ pola'),
                    ])?>
                <?php endif ?>
            </div>

            <div class="simple-box">
                <div id="fieldType">
                    <?php if (isset($fieldType)): ?>
                        <?=$fieldType?>
                    <?php else: ?>
                        <span class="text-muted">
                            <?=trans('Wybierz typ pola')?>
                        </span>
                    <?php endif ?>
                </div>
            </div>

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz węzeł'),
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function() {

    $('#type').change(function() {
        $.get("<?=$uri->mask('/types')?>/"+$(this).val(), function(data) {
            $('#fieldType').html(data);
        });
    });

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
