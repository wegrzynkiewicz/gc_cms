<?php

require ROUTES_PATH."/admin/parts/module/type/html-editor/_import.php";

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?=render(ROUTES_PATH.'/admin/parts/input/textarea.html.php', [
                'name' => 'content',
                'label' => trans('Treść modułu'),
            ])?>

            <?=render(ROUTES_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz moduł tekstowy'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script type="text/javascript">
    $(function(){
        CKEDITOR.replace('content', {
             customConfig: '/assets/admin/ckeditor/full_ckeditor.js'
        });
    });
</script>

<?php require ROUTES_PATH.'/admin/parts/footer.html.php'; ?>