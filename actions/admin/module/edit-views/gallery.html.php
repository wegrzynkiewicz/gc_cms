<?php

$headTitle = trans("Edytujesz moduł galerii");

if (wasSentPost()) {
    FrameModule::updateByPrimaryId($module_id, [
        'theme' => 'default',
        'content' => intval($_POST['gallery_id']),
    ]);
    redirect("/admin/$parentSegment/module/list/$parent_id");
}

$galleriesOptions = Gallery::selectAllAsOptionsWithPrimaryKey('name');

$_POST['gallery_id'] = $content;

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" class="form-horizontal">

            <?php if (empty($galleriesOptions)): ?>
                <p>
                    <?=trans('Żadna galeria nie istnieje.')?>
                    <a href="<?=url("/admin/gallery/new")?>">
                        <?=trans('Dodaj nową galerię')?>
                    </a>
                </p>
            <?php else: ?>
                <?=view('/admin/parts/input/selectbox.html.php', [
                    'name' => 'gallery_id',
                    'label' => 'Z której galerii wyświetlać zdjęcia w module?',
                    'help' => 'Wybierz już istniejącą galerię zdjęć, albo utwórz nową',
                    'options' => $galleriesOptions,
                    'firstOption' => 'Wybierz galerię',
                ])?>
            <?php endif ?>

            <div id='galleryPreview'></div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/$parentSegment/module/list/$parent_id",
                'saveLabel' => 'Zapisz moduł galerii',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
    $(function() {
        function refreshGallery(gallery_id) {
            $.get("<?=url("/admin/module/edit-views/gallery-preview/")?>"+gallery_id, function(data) {
                $('#galleryPreview').html(data);
            });
        }

        $('#gallery_id').change(function() {
            refreshGallery($(this).val());
        });

        <?php if (isset($_POST['gallery_id'])): ?>
            refreshGallery(<?=$_POST['gallery_id']?>);
        <?php endif ?>
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
