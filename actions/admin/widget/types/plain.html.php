<?php

$headTitle = trans("Edytujesz widżet tekstowy");

if (wasSentPost()) {
    GCC\Model\Widget::updateByPrimaryId($widget_id, [
        'content' => $_POST['content'],
    ]);
    redirect("/admin/widget/list");
}

$headTitle .= makeLink("/admin/widget/list", $widget['name']);

$_POST['content'] = $content;

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?=view('/admin/parts/input/textarea.html.php', [
                'name' => 'content',
                'label' => 'Treść widżetu',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/widget/list",
                'saveLabel' => 'Zapisz widżet',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
