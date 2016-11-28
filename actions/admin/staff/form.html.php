<?php

$groupOptions = StaffGroup::selectAllAsOptionsWithPrimaryKey('name');

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

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

            <?php if (isset($error)): ?>
                <p class="text-center"><?=$error?></p>
            <?php endif ?>

            <?=view('/admin/parts/input/image.html.php', [
                'name' => 'avatar',
                'label' => 'Avatar pracownika',
                'placeholder' => 'Ścieżka do pliku zdjęcia',
            ])?>

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'name',
                'label' => 'Imię i nazwisko pracownika',
            ])?>

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'email',
                'label' => 'Adres E-mail',
                'help' => 'Adres E-mailowy służy do logowaniu pracownika do panelu',
            ])?>

            <?=view('/admin/parts/input/select2-multi.html.php', [
                'name' => 'groups',
                'label' => 'Przynależność do grup pracowników',
                'help' => 'Możesz wybrać jaką pracownik ma pełnić funkcję i jakie uprawnienia otrzyma. Pracownik może przynależyć do wielu grup.',
                'options' => $groupOptions,
                'selectedValues' => $groups,
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/staff/list",
                'saveLabel' => 'Zapisz ustawienia',
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
            },
            email: {
                email: true,
                required: true
            }
        },
        messages: {
            name: {
                minlength: "<?=trans('Imię i nazwisko pracownika musi być dłuższe niż 4 znaki')?>",
                required: "<?=trans('Imię i nazwisko jest wymagane')?>"
            },
            email: {
                email: "<?=trans('Adres E-mail nie jest prawidłowy')?>",
                required: "<?=trans('Adres E-mail jest wymagany')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
