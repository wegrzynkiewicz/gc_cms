<?php

$headTitle = trans('Edycja widżetu tekstowego "%s"', [$widget['name']]);
$breadcrumbs->push($request, $headTitle);

if (isPost()) {
    GC\Model\Widget::updateByPrimaryId($widget_id, [
        'content' => $_POST['content'],
    ]);

    setNotice(trans('Widżet tekstowy "%s" został zaktualizowany.', [$widget['name']]));

    redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST['content'] = $content;

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=view('/admin/parts/input/textarea.html.php', [
                    'name' => 'content',
                    'label' => 'Treść widżetu',
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/widget/list",
                'saveLabel' => 'Zapisz zmiany',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
