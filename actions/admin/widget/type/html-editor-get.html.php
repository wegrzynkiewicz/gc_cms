<?php

$headTitle = $trans('Edycja widżetu formatowanego tekstu HTML "%s"', [$widget['name']]);
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

            <?=GC\Render::action('/admin/parts/input/textarea.html.php', [
                'name' => 'content',
                'label' => 'Treść widżetu',
            ])?>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz zmiany',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script type="text/javascript">
    $(function(){
        CKEDITOR.replace('content', {
             customConfig: '/assets/admin/ckeditor/full_ckeditor.js'
        });
    });
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
