<?php

require ROUTES_PATH."/admin/module/type/html-editor/_import.php";

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <?=render(ROUTES_PATH.'/admin/_parts/input/ckeditor.html.php', [
                'name' => 'content',
                'label' => trans('Treść modułu'),
                'options' => [
                     'customConfig' => $uri->root('/assets/admin/ckeditor/full_ckeditor.js'),
                ],
            ])?>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz moduł tekstowy'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
