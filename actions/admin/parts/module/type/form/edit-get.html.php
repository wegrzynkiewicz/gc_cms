<?php

$installedForms = GC\Model\Form::mapCorrectWithPrimaryKeyBy('name');

$emails = [];
foreach (def($settings, 'emails', []) as $email) {
    $emails[$email] = $email;
}

$_POST['form'] = $content;

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/selectbox.html.php', [
                    'name' => 'form',
                    'label' => 'Formularz',
                    'help' => 'Wybierz formularz który ma zostać wyświetlony',
                    'options' => $installedForms,
                    'firstOption' => 'Wybierz formularz',
                ])?>

                <?=GC\Render::action('/admin/parts/input/selectbox.html.php', [
                    'name' => 'theme',
                    'label' => 'Szablon',
                    'help' => 'Wybierz jeden z dostępnych szablonów dla formularza',
                    'options' => $config['moduleThemes']['form'],
                ])?>

                <?=GC\Render::action('/admin/parts/input/select2-tags.html.php', [
                    'id' => 'emails',
                    'name' => 'emails',
                    'label' => 'Odbiorcy mailowi',
                    'help' => 'Można wpisać adresy mailowe na które zostanie wysłany każdy wypełniony formularz. Należy potwierdzić klawiszem ENTER.',
                    'options' => $emails,
                    'selectedValues' => $emails,
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz moduł',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('form').validate({
        rules: {
            form: {
                required: true,
            },
        },
        messages: {
            form: {
                required: "<?=trans('Musisz wybrać formularz')?>",
            },
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
