<?php

$groupOptions = GC\Model\Staff\Group::select()
    ->fields(['group_id', 'name'])
    ->fetchByMap('group_id', 'name');

?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/parts/input/_image.html.php', [
                    'name' => 'avatar',
                    'label' => trans('Avatar pracownika'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/_editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Imię i nazwisko pracownika'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/_editbox.html.php', [
                    'name' => 'email',
                    'label' => trans('Adres E-mail'),
                    'help' => trans('Adres E-mail służy do logowaniu pracownika do panelu'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/parts/input/_select2-multi.html.php', [
                    'name' => 'groups',
                    'label' => trans('Przynależność do grup pracowników'),
                    'help' => trans('Możesz wybrać jaką pracownik ma pełnić funkcję i jakie uprawnienia otrzyma. Pracownik może przynależyć do wielu grup.'),
                    'options' => $groupOptions,
                    'selectedValues' => $groups,
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/parts/input/_submitButtons.html.php', [
                'saveLabel' => trans('Zapisz ustawienia'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/_footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/_end.html.php'; ?>
