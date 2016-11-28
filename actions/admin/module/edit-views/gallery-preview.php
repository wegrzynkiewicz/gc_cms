<?php

$headTitle = trans('Podgląd galerii');

$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));
$gallery = Gallery::selectByPrimaryId($gallery_id);
$headTitle .= makeLink("/admin/gallery/edit/$gallery_id", $gallery['name']);
$images = GalleryImage::selectAllByGalleryId($gallery_id);

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?=url("/admin/gallery/images/list/$gallery_id")?>" class="pull-right">
            <?=trans('Edytuj galerię')?>
        </a>
        <?=$headTitle?>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php if(empty($images)): ?>
            <?=trans('Brak zdjęć w galerii')?>
        <?php else: ?>
            <div class="module-gallery-preview-row">
                <?php foreach ($images as $image): ?>
                    <div class="module-gallery-preview-wrapper">
                        <img src="<?=thumb($image['file'], 120, 70)?>"
                            width="120"
                            width="70"
                            class="module-gallery-preview-image"/>
                    </div>
                <?php endforeach ?>
                <div class="clearfix"></div>
            </div>
        <?php endif ?>
    </div>
</div>
