<?php

$headTitle = trans('Edycja widżetu formatowanego tekstu HTML: %s', [$widget['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?=render(ROUTES_PATH.'/admin/parts/input/ckeditor.html.php', [
                'name' => 'content',
                'label' => trans('Treść widżetu'),
                'options' => [
                     'customConfig' => '/assets/admin/ckeditor/full_ckeditor.js',
                ],
            ])?>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz zmiany'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/end.html.php'; ?>
