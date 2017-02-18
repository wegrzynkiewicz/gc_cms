<?php $is = json_decode($image['settings'], true) ?>

<div id="thumb_<?=e($file_id)?>"
    data-id="<?=e($file_id)?>"
    class="col-lg-2 col-md-4 col-xs-6 sortable-container">

    <div class="thumbnail">

        <div class="thumb-wrapper">
            <a href="<?=e($image['uri'])?>"
                target="_blank"
                title="<?=e($image['name'])?>"
                data-photoswipe-item=""
                data-width="<?=e($is['width'])?>"
                data-height="<?=e($is['height'])?>"
                class="thumb-wrapper">
                <img src="<?=$uri->root(thumbnail($image['uri'], 300, 200))?>"
                    alt="<?=e($image['name'])?>"
                    class="img-responsive">
            </a>
        </div>

        <div class="pull-right">

            <a id="thumb_edit_<?=e($file_id)?>"
                data-toggle="modal"
                data-id="<?=e($file_id)?>"
                data-name="<?=e($image['name'])?>"
                data-target="#editModal"
                title="<?=$trans('Edytuj zdjęcie')?>"
                class="btn btn-primary btn-xs">
                <i class="fa fa-cog fa-fw"></i>
            </a>

            <a id="thumb_delete_<?=e($file_id)?>"
                data-toggle="modal"
                data-id="<?=e($file_id)?>"
                data-name="<?=e($image['name'])?>"
                data-target="#deleteModal"
                title="<?=$trans('Usuń zdjęcie')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
            </a>
        </div>

        <div class="thumb-description" title="<?=e($image['name'])?>">
            <?=e($image['name'])?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
