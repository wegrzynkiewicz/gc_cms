<?php

checkPermissions();

$gallery_id = intval(array_shift($_SEGMENTS));
$images = GalleryImageModel::selectAllByGroupId($gallery_id);

?>
<?php if (empty($images)): ?>
    <div class="col-lg-12">
        <p>
            <?=trans('Brak zdjęć w galerii')?>
        </p>
        <hr>
    </div>
<?php else: ?>
    <?php foreach ($images as $id => $row): ?>
        <div id="thumb_<?=$id?>" data-id="<?=$id?>" class="col-lg-2 col-md-4 col-xs-6 thumb">
            <div class="thumbnail">

                <div class="thumb-wrapper">
                    <img src="<?=rootUrl($row['file'])?>" class="img-responsive"/>
                </div>

                <div class="pull-right">

                    <a href="<?=url("/admin/gallery-images/edit/$id/$gallery_id/cycki")?>"
                        data-toggle="modal"
                        title="<?=trans('Edytuj stronę')?>"
                        class="btn btn-primary btn-xs">
                        <i class="fa fa-cog fa-fw"></i>
                    </a>

                    <a data-toggle="modal"
                        data-id="<?=$id?>"
                        data-name="<?=$row['name']?>"
                        data-target="#deleteModal"
                        title="<?=trans('Usuń zdjęcie')?>"
                        class="btn btn-danger btn-xs">
                        <i class="fa fa-times fa-fw"></i>
                    </a>
                </div>

                <div class="thumb-description" title="<?=escape($row['name'])?>">
                    <?=escape($row['name'])?>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
