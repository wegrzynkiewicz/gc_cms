<?php

$headTitle = $trans('Edycja widżetu tekstowego "%s"', [$widget['name']]);
$breadcrumbs->push([
    'url' => $request->path,
    'name' => $headTitle,
]);

$_POST['content'] = $content;

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=GC\Render::action('/admin/parts/input/textarea.html.php', [
                    'name' => 'content',
                    'label' => 'Treść widżetu',
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/widget/list",
                'saveLabel' => 'Zapisz zmiany',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
