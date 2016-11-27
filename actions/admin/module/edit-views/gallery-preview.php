<?php

$headTitle = trans('Podgląd galerii');

$staff->redirectIfUnauthorized();

$gallery_id = intval(array_shift($_SEGMENTS));
$gallery = GalleryModel::selectByPrimaryId($gallery_id);
$headTitle .= makeLink("/admin/gallery/edit/$gallery_id", $gallery['name']);
$images = GalleryImageModel::selectAllByGroupId($gallery_id);

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
        <div class="row">
            <?php if(empty($images)): ?>
                <div class="col-md-12">
                    <?=trans('Brak zdjęć w galerii')?>
                </div>
            <?php else: ?>
                <?php foreach ($images as $image): ?>
                    <div class="col-md-2">
                        <img src="<?=rootUrl($image['file'])?>" style="width:100%; height auto;" />
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>
