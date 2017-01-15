<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Nazwa grupy',
                    'help' => 'Nazwa grupy pomaga określić odpowiedzialność członków grupy (np. Sprzedawcy, Administratorzy)'
                ])?>

                <fieldset>
                    <legend>
                        <?=$trans('Uprawnienia grupy')?>
                    </legend>

                    <p>
                        <?=$trans('Każda grupa posiada indywidualne uprawnienia, które są identyczne dla każdego pracownika w tej grupie.')?>
                        <?=$trans('W przypadku gdy pracownik należy do wielu grup, uprawnienia te są łączone.')?>
                    </p>

                    <?php foreach ($config['permissions'] as $perm => $label): ?>
                        <div class="checkbox">
                            <label>
                                <input name="permissions[]"
                                    type="checkbox"
                                    <?=checked(in_array($perm, $permissions))?>
                                    value="<?=e($perm)?>">
                                <?=$trans($label)?>
                            </label>
                        </div>
                    <?php endforeach ?>
                </fieldset>
            </div>

            <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz grupę',
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
                required: "<?=$trans('Nazwa grupy jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
