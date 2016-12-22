<?php

$headTitle = trans('Edycja widżetu zdjęcia "%s"', [$widget['name']]);
$breadcrumbs->push($request, $headTitle);

if (isPost()) {
    GC\Model\Widget::updateByPrimaryId($widget_id, [
        'content' => $_POST['content'],
    ]);

    setNotice(trans('Widżet zdjęcia "%s" został zaktualizowany.', [$widget['name']]));

    GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST['content'] = $content;

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/image.html.php', [
                    'name' => 'content',
                    'label' => 'Zdjęcie',
                    'placeholder' => 'Ścieżka do pliku zdjęcia',
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz zmiany',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
