<?php
    $images = GC\Model\Module\File::joinAllWithKeyByForeign($module_id);
    $thumbsPerRow = $settings['thumbsPerRow'] ?? 12;
    $gutter = ceil(($settings['gutter'] ?? 20)/2)*2;
    $colWidth = ceil(12/$thumbsPerRow);
    $chunks = array_chunk($images, $thumbsPerRow);
    $gutterHalf = ceil($gutter/2);
?>

<style>
    #gallery_<?=e($module_id)?> .row.gutter-<?=$gutter?> {
        margin-left: -<?=$gutterHalf?>px;
        margin-right: -<?=$gutterHalf?>px;
    }
    #gallery_<?=e($module_id)?> .row.gutter-<?=$gutter?>>[class*="col-"] {
        padding-left: <?=$gutterHalf?>px;
        padding-right: <?=$gutterHalf?>px;
    }
</style>

<div id="gallery_<?=e($module_id)?>" data-gallery="photoswipe">
    <div class="row gutter-<?=$gutter?>">
        <?php foreach ($chunks as $images): ?>
            <?php foreach ($images as $image_id => $image): ?>
                <?php $is = json_decode($image['settings'], true); ?>
                <div class="col-md-<?=$colWidth?>">
                    <a href="<?=e($image['uri'])?>"
                        target="_blank"
                        title="<?=e($image['name'])?>"
                        data-photoswipe-item=""
                        data-width="<?=e($is['width'])?>"
                        data-height="<?=e($is['height'])?>">
                        <img data-thumb="<?=$image['uri']?>"
                            width="100%"
                            alt="<?=e($image['name'])?>"
                            class="img-responsive">
                    </a>
                </div>
            <?php endforeach ?>
            <div class="clearfix visible-md visible-lg"></div>
        <?php endforeach ?>
    </div>
</div>
