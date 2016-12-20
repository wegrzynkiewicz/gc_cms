<?php

$headTitle = trans("Edycja modułu formularza");
$breadcrumbs->push($request, $headTitle);

if (isPost()) {
    sort($_POST['emails']);
    $settings['emails'] = $_POST['emails'];
    GC\Model\FrameModule::updateByPrimaryId($module_id, [
        'content' => $_POST['form'],
        'theme' => $_POST['theme'],
        'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
    ]);

    setNotice(trans('Moduł formularza został zaktualizowany.'));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$options = GC\Model\Form::mapCorrectWithPrimaryKeyBy('name');

$emails = [];
foreach (def($settings, 'emails', []) as $email) {
    $emails[$email] = $email;
}

$_POST['form'] = $content;

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=view('/admin/parts/input/selectbox.html.php', [
                    'name' => 'form',
                    'label' => 'Formularz',
                    'help' => 'Wybierz formularz który ma zostać wyświetlony',
                    'options' => $options,
                    'firstOption' => 'Wybierz formularz',
                ])?>

                <?=view('/admin/parts/input/selectbox.html.php', [
                    'name' => 'theme',
                    'label' => 'Szablon',
                    'help' => 'Wybierz jeden z dostępnych szablonów dla formularza',
                    'options' => $config['moduleThemes']['form'],
                ])?>

                <?=view('/admin/parts/input/select2-tags.html.php', [
                    'id' => 'emails',
                    'name' => 'emails',
                    'label' => 'Odbiorcy mailowi',
                    'help' => 'Można wpisać adresy mailowe na które zostanie wysłany każdy wypełniony formularz. Należy potwierdzić klawiszem ENTER.',
                    'options' => $emails,
                    'selectedValues' => $emails,
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz moduł',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script type="text/javascript">
    $(function(){
        CKEDITOR.replace('content', {
             customConfig: '/assets/admin/ckeditor/full_ckeditor.js'
        });
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
