<?php

$groupOptions = GC\Model\Staff\Group::select()
    ->fields(['group_id', 'name'])
    ->fetchByMap('group_id', 'name');

?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/parts/input/image.html.php', [
                    'name' => 'avatar',
                    'label' => trans('Avatar pracownika'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Imię i nazwisko pracownika'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'email',
                    'label' => trans('Adres E-mail'),
                    'help' => trans('Adres E-mail służy do logowaniu pracownika do panelu'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/select2-multi.html.php', [
                    'name' => 'groups',
                    'label' => trans('Przynależność do grup pracowników'),
                    'help' => trans('Możesz wybrać jaką pracownik ma pełnić funkcję i jakie uprawnienia otrzyma. Pracownik może przynależyć do wielu grup.'),
                    'options' => $groupOptions,
                    'selectedValues' => $groups,
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz ustawienia'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                email: true,
                required: true,
                remote: {
                    url: "<?=$uri->make("/admin/api/validate/xhr-staff-email/{$staff_id}")?>",
                },
            },
        },
        messages: {
            name: {
                required: "<?=trans('Imię i nazwisko jest wymagane')?>",
            },
            email: {
                email: "<?=trans('Adres E-mail nie jest prawidłowy')?>",
                required: "<?=trans('Adres E-mail jest wymagany')?>",
                remote: "<?=trans('Adres E-mail jest już wykorzystywany')?>",
            },
        },
    });
});
</script>

<?php require ROUTES_PATH.'/admin/parts/end.html.php'; ?>
