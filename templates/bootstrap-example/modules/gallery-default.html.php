<?php
$images = ModuleFile::selectAllByModuleId($module_id);
?>

<div id="gallery_<?=$module_id?>" data-gallery="photoswipe">
    <?php foreach ($images as $image_id => $image): $is = json_decode($image['settings'], true); ?>
        <div>
            <a href="<?=$image['url']?>"
                title="<?=escape($image['name'])?>"
                data-width="<?=$is['width']?>"
                data-height="<?=$is['height']?>">
                <img src="<?=Thumb::make($image['url'], 200, 200)?>"
                    alt="<?=escape($image['name'])?>"
                    class="img-responsive">
            </a>
        </div>
    <?php endforeach ?>
</div>
