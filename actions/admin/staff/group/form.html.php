<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa grupy'),
                    'help' => trans('Nazwa grupy pomaga określić odpowiedzialność członków grupy (np. Sprzedawcy, Administratorzy)')
                ])?>
            </div>

            <div class="simple-box">
                <fieldset>
                    <legend>
                        <?=trans('Uprawnienia grupy')?>
                    </legend>

                    <p>
                        <?=trans('Każda grupa posiada indywidualne uprawnienia, które są identyczne dla każdego pracownika w tej grupie.')?>
                        <?=trans('W przypadku gdy pracownik należy do wielu grup, uprawnienia te są łączone.')?>
                    </p>

                    <?php foreach (array_trans($config['permissions']) as $perm => $label): ?>
                        <div class="checkbox">
                            <label>
                                <input name="permissions[]"
                                    type="checkbox"
                                    <?=checked(in_array($perm, $permissions))?>
                                    value="<?=$perm?>">
                                <?=$label?>
                            </label>
                        </div>
                    <?php endforeach ?>
                </fieldset>
            </div>

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz grupę'),
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
                required: true
            }
        },
        messages: {
            name: {
                required: "<?=trans('Nazwa grupy jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
