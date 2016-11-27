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
                'label' => 'Nazwa grupy',
                'help' => 'Nazwa grupy pomaga określić odpowiedzialność członków grupy (np. Sprzedawcy, Administratorzy)'
            ])?>

            <fieldset>
                <legend>
                    <?=trans('Uprawnienia grupy')?>
                </legend>

                <p>
                    <?=trans('Każda grupa posiada indywidualne uprawnienia, które są identyczne dla każdego pracownika w tej grupie.')?>
                    <?=trans('W przypadku gdy pracownik należy do wielu grup, uprawnienia te są łączone.')?>
                </p>

                <?php foreach ($config['permissions'] as $perm => $label): ?>
                    <div class="checkbox">
                        <label>
                            <input name="permissions[]"
                                type="checkbox"
                                <?=checked(in_array($perm, $permissions))?>
                                value="<?=$perm?>">
                            <?=trans($label)?>
                        </label>
                    </div>
                <?php endforeach ?>
            </fieldset>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/staff/group/list",
                'saveLabel' => 'Zapisz grupę',
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
                minlength: "<?=trans('Nazwa grupy musi być dłuższa niż 4 znaki')?>",
                required: "<?=trans('Nazwa grupy jest wymagana')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>