<?php

$headTitle = trans("Edycja modułu formularza");
$breadcrumbs->push($request, $headTitle);

if (isPost()) {
    GC\Model\FrameModule::updateByPrimaryId($module_id, [
        'content' => $_POST['form'],
        'theme' => $_POST['theme'],
    ]);

    setNotice(trans('Moduł formularza został zaktualizowany.'));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$options = GC\Model\Form::selectAllOptionsWithPrimaryKey('name');


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
