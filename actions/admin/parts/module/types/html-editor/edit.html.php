<?php

$headTitle = trans("Edycja modułu tekstowego");
$breadcrumbs->push($request, $headTitle);

if (wasSentPost()) {
    GC\Model\FrameModule::updateByPrimaryId($module_id, [
        'content' => $_POST['content'],
        'theme' => 'default',
    ]);

    redirect($breadcrumbs->getBeforeLastUrl());
}


$_POST['content'] = $content;

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?=view('/admin/parts/input/textarea.html.php', [
                'name' => 'content',
                'label' => 'Treść modułu',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz moduł tekstowy',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script type="text/javascript">
    $(function(){
        CKEDITOR.replace('content', {
             customConfig: '/assets/admin/ckeditor/full_ckeditor.js'
        });
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
