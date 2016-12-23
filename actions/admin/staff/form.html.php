<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?php if (isset($error)): ?>
                    <p class="text-center"><?=e($error)?></p>
                <?php endif ?>

                <?=GC\Render::action('/admin/parts/input/image.html.php', [
                    'name' => 'avatar',
                    'label' => 'Avatar pracownika',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => 'Imię i nazwisko pracownika',
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'email',
                    'label' => 'Adres E-mail',
                    'help' => 'Adres E-mailowy służy do logowaniu pracownika do panelu',
                ])?>

                <?=GC\Render::action('/admin/parts/input/select2-multi.html.php', [
                    'name' => 'groups',
                    'label' => 'Przynależność do grup pracowników',
                    'help' => 'Możesz wybrać jaką pracownik ma pełnić funkcję i jakie uprawnienia otrzyma. Pracownik może przynależyć do wielu grup.',
                    'options' => GC\Model\StaffGroup::mapWithPrimaryKeyBy('name'),
                    'selectedValues' => $groups,
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz ustawienia',
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
            },
            email: {
                email: true,
                required: true
            }
        },
        messages: {
            name: {
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

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
