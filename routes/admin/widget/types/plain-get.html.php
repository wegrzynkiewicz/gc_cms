<?php

$headTitle = trans('Edycja widżetu tekstowego: %s', [$widget['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/parts/input/textarea.html.php', [
                    'name' => 'content',
                    'label' => trans('Treść widżetu'),
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz zmiany'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/footer.html.php'; ?>
