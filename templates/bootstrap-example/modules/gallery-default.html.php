<?php
$images = GC\Model\ModuleFile::selectAllByModuleId($module_id);
?>

<div id="gallery_<?=$module_id?>" data-gallery="photoswipe">
    <?php foreach ($images as $image_id => $image): $is = json_decode($image['settings'], true); ?>
        <div>
            <a href="<?=$image['url']?>"
                target="_blank"
                title="<?=escape($image['name'])?>"
                data-photoswipe-item=""
                data-width="<?=$is['width']?>"
                data-height="<?=$is['height']?>">
                <img src="<?=GC\Thumb::make($image['url'], 200, 200)?>"
                    alt="<?=escape($image['name'])?>"
                    class="img-responsive">
            </a>
        </div>
    <?php endforeach ?>
</div>
