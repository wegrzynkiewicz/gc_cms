<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <?=render(ROUTES_PATH."/admin/parts/input/_ckeditor.html.php", [
                'name' => 'content',
                'label' => trans('Treść modułu'),
                'options' => [
                     'customConfig' => $uri->root('/assets/admin/ckeditor-full.js'),
                ],
            ])?>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz moduł tekstowy'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
