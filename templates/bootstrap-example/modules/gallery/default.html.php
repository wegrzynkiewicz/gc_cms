<?php
$images = GC\Model\ModuleFile::selectAllByModuleId($module_id);
?>

<div id="gallery_<?=e($module_id)?>" data-gallery="photoswipe">
    <?php foreach ($images as $image_id => $image): $is = json_decode($image['settings'], true); ?>
        <div>
            <a href="<?=e($image['url'])?>"
                target="_blank"
                title="<?=e($image['name'])?>"
                data-photoswipe-item=""
                data-width="<?=e($is['width'])?>"
                data-height="<?=e($is['height'])?>">
                <img src="<?=GC\Thumb::make($image['url'], 200, 200)?>"
                    alt="<?=e($image['name'])?>"
                    class="img-responsive">
            </a>
        </div>
    <?php endforeach ?>
</div>
