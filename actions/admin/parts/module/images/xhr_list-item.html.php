<?php $is = json_decode($image['settings'], true) ?>

<div id="thumb_<?=$file_id?>"
    data-id="<?=$file_id?>"
    class="col-lg-2 col-md-4 col-xs-6 thumb">

    <div class="thumbnail">

        <div class="thumb-wrapper">
            <a href="<?=$image['url']?>"
                target="_blank"
                title="<?=escape($image['name'])?>"
                data-photoswipe-item=""
                data-width="<?=$is['width']?>"
                data-height="<?=$is['height']?>"
                class="thumb-wrapper">
                <img src="<?=GrafCenter\CMS\Thumb::make($image['url'], 300, 200)?>"
                    alt="<?=escape($image['name'])?>"
                    class="img-responsive">
            </a>
        </div>

        <div class="pull-right">

            <a id="thumb_edit_<?=$file_id?>"
                data-toggle="modal"
                data-id="<?=$file_id?>"
                data-name="<?=$image['name']?>"
                data-target="#editModal"
                title="<?=trans('Edytuj zdjęcie')?>"
                class="btn btn-primary btn-xs">
                <i class="fa fa-cog fa-fw"></i>
            </a>

            <a id="thumb_delete_<?=$file_id?>"
                data-toggle="modal"
                data-id="<?=$file_id?>"
                data-name="<?=$image['name']?>"
                data-target="#deleteModal"
                title="<?=trans('Usuń zdjęcie')?>"
                class="btn btn-danger btn-xs">
                <i class="fa fa-times fa-fw"></i>
            </a>
        </div>

        <div class="thumb-description" title="<?=escape($image['name'])?>">
            <?=escape($image['name'])?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
