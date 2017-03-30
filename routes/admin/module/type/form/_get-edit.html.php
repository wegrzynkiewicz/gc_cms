<?php

$installedForms = GC\Model\Form\Form::select()
    ->fields('::primary, name')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByMap('form_id', 'name');

$emails = [];
foreach ($settings['emails'] ?? [] as $email) {
    $emails[$email] = $email;
}

$_POST['form'] = $content;

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                    'name' => 'form',
                    'label' => trans('Formularz'),
                    'help' => trans('Wybierz formularz który ma zostać wyświetlony'),
                    'options' => $installedForms,
                    'firstOption' => trans('Wybierz formularz'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                    'name' => 'theme',
                    'label' => trans('Szablon'),
                    'help' => trans('Wybierz jeden z dostępnych szablonów dla formularza'),
                    'options' => $config['moduleThemes']['form'],
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/select2-tags.html.php', [
                    'id' => 'emails',
                    'name' => 'emails',
                    'label' => trans('Odbiorcy mailowi'),
                    'help' => trans('Można wpisać adresy mailowe na które zostanie wysłany każdy wypełniony formularz. Należy potwierdzić klawiszem ENTER.'),
                    'options' => $emails,
                    'selectedValues' => $emails,
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz moduł'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
