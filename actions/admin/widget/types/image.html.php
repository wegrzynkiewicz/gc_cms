<?php

$headTitle = trans('Edycja widżetu zdjęcia "%s"', [$widget['name']]);
$breadcrumbs->push($request, $headTitle);

if (isPost()) {
    GC\Model\Widget::updateByPrimaryId($widget_id, [
        'content' => $_POST['content'],
    ]);

    setNotice(trans('Widżet zdjęcia "%s" został zaktualizowany.', [$widget['name']]));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST['content'] = $content;

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=view('/admin/parts/input/image.html.php', [
                    'name' => 'content',
                    'label' => 'Zdjęcie',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz zmiany',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
